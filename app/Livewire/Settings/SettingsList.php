<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\Departamento;
use App\Models\Sucursal;

class SettingsList extends Component
{
    public $activeTab = 'departamentos';

    // Modelos para creación/edición
    public $depto_id, $depto_nombre;
    public $sucursal_id, $sucursal_nombre, $sucursal_activa = true;

    // Modals state
    public $showDeptoModal = false;
    public $showSucursalModal = false;

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    // --- DEPARTAMENTOS ---

    public function openDeptoModal($id = null)
    {
        $this->resetErrorBag();
        if ($id) {
            $depto = Departamento::findOrFail($id);
            $this->depto_id = $depto->id;
            $this->depto_nombre = $depto->nombre;
        } else {
            $this->depto_id = null;
            $this->depto_nombre = '';
        }
        $this->showDeptoModal = true;
    }

    public function closeDeptoModal()
    {
        $this->showDeptoModal = false;
    }

    public function saveDepto()
    {
        $this->validate([
            'depto_nombre' => 'required|string|max:255'
        ]);

        if ($this->depto_id) {
            Departamento::where('id', $this->depto_id)->update(['nombre' => $this->depto_nombre]);
            session()->flash('message', 'Departamento actualizado correctamente.');
        } else {
            Departamento::create(['nombre' => $this->depto_nombre]);
            session()->flash('message', 'Departamento creado correctamente.');
        }
        $this->closeDeptoModal();
    }

    public function deleteDepto($id)
    {
        $depto = Departamento::findOrFail($id);
        if ($depto->users()->count() > 0 || $depto->equipos()->count() > 0 || $depto->tickets()->count() > 0) {
            session()->flash('error', 'No se puede eliminar el departamento porque tiene registros asociados.');
            return;
        }
        $depto->delete();
        session()->flash('message', 'Departamento eliminado.');
    }


    // --- SUCURSALES ---

    public function openSucursalModal($id = null)
    {
        $this->resetErrorBag();
        if ($id) {
            $sucursal = Sucursal::findOrFail($id);
            $this->sucursal_id = $sucursal->id;
            $this->sucursal_nombre = $sucursal->nombre;
            $this->sucursal_activa = $sucursal->activa;
        } else {
            $this->sucursal_id = null;
            $this->sucursal_nombre = '';
            $this->sucursal_activa = true;
        }
        $this->showSucursalModal = true;
    }

    public function closeSucursalModal()
    {
        $this->showSucursalModal = false;
    }

    public function saveSucursal()
    {
        $this->validate([
            'sucursal_nombre' => 'required|string|max:255',
            'sucursal_activa' => 'boolean'
        ]);

        if ($this->sucursal_id) {
            Sucursal::where('id', $this->sucursal_id)->update([
                'nombre' => $this->sucursal_nombre,
                'activa' => $this->sucursal_activa
            ]);
            session()->flash('message', 'Sucursal actualizada correctamente.');
        } else {
            Sucursal::create([
                'nombre' => $this->sucursal_nombre,
                'activa' => $this->sucursal_activa
            ]);
            session()->flash('message', 'Sucursal creada correctamente.');
        }
        $this->closeSucursalModal();
    }

    public function deleteSucursal($id)
    {
        $sucursal = Sucursal::findOrFail($id);
        if ($sucursal->equipos()->count() > 0 || $sucursal->tickets()->count() > 0) {
            session()->flash('error', 'No se puede eliminar la sucursal porque tiene registros asociados.');
            return;
        }
        $sucursal->delete();
        session()->flash('message', 'Sucursal eliminada.');
    }

    public function render()
    {
        return view('livewire.settings.settings-list', [
            'departamentos' => Departamento::withCount(['users', 'equipos'])->get(),
            'sucursales' => Sucursal::withCount(['equipos'])->get(),
        ])->layout('layouts.app');
    }
}
