<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Department;
use App\Models\Branch;
use App\Services\SafeZipExtractor;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class SettingsList extends Component
{
    use WithFileUploads;

    public $activeTab = 'departments';

    // Modelos para creación/edición
    public $department_id, $department_name;
    public $branch_id, $branch_name, $branch_is_active = true;

    // Modals state
    public $showDepartmentModal = false;
    public $showBranchModal = false;

    // Despliegue / Actualización ZIP
    public $zip_file;
    public $deployMessage = null;
    public $deployError = null;

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->deployMessage = null;
        $this->deployError = null;
    }

    // --- DESPLIEGUE Y ACTUALIZACIÓN ---
    public function processDeploy()
    {
        $this->validate([
            'zip_file' => 'required|file|mimes:zip|max:51200', // Máx 50MB
        ], [
            'zip_file.required' => 'Debes seleccionar un archivo ZIP.',
            'zip_file.mimes' => 'El archivo debe estar en formato .ZIP',
            'zip_file.max' => 'El archivo ZIP no puede superar los 50MB.',
        ]);

        try {
            $this->deployMessage = null;
            $this->deployError = null;

            // 1. Guardar archivo temporalmente
            $tempPath = $this->zip_file->getRealPath();

            // 2. Hacer respaldo automático del código actual
            SafeZipExtractor::backupCurrentCode('auto_backup_before_deploy');

            // 3. Extraer actualización sobre el proyecto
            $result = SafeZipExtractor::extract($tempPath);

            // 4. Ejecutar migraciones si las hay
            try {
                Artisan::call('migrate', ['--force' => true]);
            } catch (\Exception $e) {
                // Continuar aunque falle migración minor
            }

            // 5. Limpiar cachés
            Artisan::call('config:clear');
            Artisan::call('cache:clear');
            Artisan::call('view:clear');
            Artisan::call('route:clear');

            $this->reset('zip_file');
            $this->deployMessage = "¡Actualización aplicada con éxito! Se extrajeron {$result['extracted_count']} archivos y se creó un respaldo automático.";
            $this->dispatch('notify', message: 'Sistema actualizado correctamente.');

        } catch (\Exception $e) {
            $this->deployError = "Error al procesar la actualización: " . $e->getMessage();
        }
    }

    // --- DEPARTAMENTOS ---

    public function openDepartmentModal($id = null)
    {
        $this->resetErrorBag();
        if ($id) {
            $department = Department::findOrFail($id);
            $this->department_id = $department->id;
            $this->department_name = $department->name;
        } else {
            $this->department_id = null;
            $this->department_name = '';
        }
        $this->showDepartmentModal = true;
    }

    public function closeDepartmentModal()
    {
        $this->showDepartmentModal = false;
    }

    public function saveDepartment()
    {
        $this->validate([
            'department_name' => 'required|string|max:255'
        ]);

        if ($this->department_id) {
            Department::where('id', $this->department_id)->update(['name' => $this->department_name]);
            $this->dispatch('notify', message: 'Departamento actualizado correctamente.');
        } else {
            Department::create(['name' => $this->department_name]);
            $this->dispatch('notify', message: 'Departamento creado correctamente.');
        }
        \Illuminate\Support\Facades\Cache::forget('ticket_form_dropdowns');
        \Illuminate\Support\Facades\Cache::forget('inventory_dropdowns_v3');
        $this->closeDepartmentModal();
    }

    public function deleteDepartment($id)
    {
        $department = Department::findOrFail($id);
        if ($department->users()->count() > 0 || $department->devices()->count() > 0 || $department->tickets()->count() > 0) {
            session()->flash('error', 'No se puede eliminar el departamento porque tiene registros asociados.');
            return;
        }
        $department->delete();
        \Illuminate\Support\Facades\Cache::forget('ticket_form_dropdowns');
        \Illuminate\Support\Facades\Cache::forget('inventory_dropdowns_v3');
        $this->dispatch('notify', message: 'Departamento eliminado.');
    }


    // --- SUCURSALES ---

    public function openBranchModal($id = null)
    {
        $this->resetErrorBag();
        if ($id) {
            $branch = Branch::findOrFail($id);
            $this->branch_id = $branch->id;
            $this->branch_name = $branch->name;
            $this->branch_is_active = $branch->is_active;
        } else {
            $this->branch_id = null;
            $this->branch_name = '';
            $this->branch_is_active = true;
        }
        $this->showBranchModal = true;
    }

    public function closeBranchModal()
    {
        $this->showBranchModal = false;
    }

    public function saveBranch()
    {
        $this->validate([
            'branch_name' => 'required|string|max:255',
            'branch_is_active' => 'boolean'
        ]);

        if ($this->branch_id) {
            Branch::where('id', $this->branch_id)->update([
                'name' => $this->branch_name,
                'is_active' => $this->branch_is_active
            ]);
            $this->dispatch('notify', message: 'Sucursal actualizada correctamente.');
        } else {
            Branch::create([
                'name' => $this->branch_name,
                'is_active' => $this->branch_is_active
            ]);
            $this->dispatch('notify', message: 'Sucursal creada correctamente.');
        }
        \Illuminate\Support\Facades\Cache::forget('ticket_form_dropdowns');
        \Illuminate\Support\Facades\Cache::forget('inventory_dropdowns_v3');
        $this->closeBranchModal();
    }

    public function deleteBranch($id)
    {
        $branch = Branch::findOrFail($id);
        if ($branch->devices()->count() > 0 || $branch->tickets()->count() > 0) {
            session()->flash('error', 'No se puede eliminar la sucursal porque tiene registros asociados.');
            return;
        }
        $branch->delete();
        \Illuminate\Support\Facades\Cache::forget('ticket_form_dropdowns');
        \Illuminate\Support\Facades\Cache::forget('inventory_dropdowns_v3');
        $this->dispatch('notify', message: 'Sucursal eliminada.');
    }

    public function render()
    {
        return view('livewire.settings.settings-list', [
            'departments' => Department::withCount(['users', 'devices'])->get(),
            'branches' => Branch::withCount(['devices'])->get(),
        ])->layout('layouts.app');
    }
}
