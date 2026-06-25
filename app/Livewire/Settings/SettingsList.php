<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\Department;
use App\Models\Branch;

class SettingsList extends Component
{
    public $activeTab = 'departments';

    // Modelos para creación/edición
    public $department_id, $department_name;
    public $branch_id, $branch_name, $branch_is_active = true;

    // Modals state
    public $showDepartmentModal = false;
    public $showBranchModal = false;

    public function setTab($tab)
    {
        $this->activeTab = $tab;
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
            $this->dispatch('notify', message: 'Departamento actualizado correctamente.'); session()->flash('message', 'Departamento actualizado correctamente.');
        } else {
            Department::create(['name' => $this->department_name]);
            $this->dispatch('notify', message: 'Departamento creado correctamente.'); session()->flash('message', 'Departamento creado correctamente.');
        }
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
        $this->dispatch('notify', message: 'Departamento eliminado.'); session()->flash('message', 'Departamento eliminado.');
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
            $this->dispatch('notify', message: 'Sucursal actualizada correctamente.'); session()->flash('message', 'Sucursal actualizada correctamente.');
        } else {
            Branch::create([
                'name' => $this->branch_name,
                'is_active' => $this->branch_is_active
            ]);
            $this->dispatch('notify', message: 'Sucursal creada correctamente.'); session()->flash('message', 'Sucursal creada correctamente.');
        }
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
        $this->dispatch('notify', message: 'Sucursal eliminada.'); session()->flash('message', 'Sucursal eliminada.');
    }

    public function render()
    {
        return view('livewire.settings.settings-list', [
            'departments' => Department::withCount(['users', 'devices'])->get(),
            'branches' => Branch::withCount(['devices'])->get(),
        ])->layout('layouts.app');
    }
}
