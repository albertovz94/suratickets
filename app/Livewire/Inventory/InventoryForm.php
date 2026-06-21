<?php

namespace App\Livewire\Inventory;

use Livewire\Component;
use App\Models\Equipo;
use App\Models\Departamento;
use App\Models\Sucursal;

class InventoryForm extends Component
{
    public $equipo_id;
    public $name = '';
    public $specs = '';
    public $type = 'Laptop';
    public $serial_number = '';
    public $sucursal_id = '';
    public $departamento_id = '';
    public $status = 'Activo';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'specs' => 'nullable|string|max:255',
            'type' => 'required|in:Laptop,Desktop,Servidor,Red,Impresora,Otro',
            'serial_number' => 'required|string|unique:equipos,serial_number,' . $this->equipo_id,
            'sucursal_id' => 'nullable|exists:sucursales,id',
            'departamento_id' => 'nullable|exists:departamentos,id',
            'status' => 'required|in:Activo,En reparacion,De baja',
        ];
    }

    public function mount($id = null)
    {
        if ($id) {
            $equipo = Equipo::findOrFail($id);
            $this->equipo_id = $equipo->id;
            $this->name = $equipo->name;
            $this->specs = $equipo->specs;
            $this->type = $equipo->type;
            $this->serial_number = $equipo->serial_number;
            $this->sucursal_id = $equipo->sucursal_id;
            $this->departamento_id = $equipo->departamento_id;
            $this->status = $equipo->status;
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'specs' => $this->specs,
            'type' => $this->type,
            'serial_number' => $this->serial_number,
            'sucursal_id' => $this->sucursal_id ?: null,
            'departamento_id' => $this->departamento_id ?: null,
            'status' => $this->status,
        ];

        if ($this->equipo_id) {
            Equipo::where('id', $this->equipo_id)->update($data);
            session()->flash('message', 'Equipo actualizado correctamente.');
        } else {
            Equipo::create($data);
            session()->flash('message', 'Equipo creado correctamente.');
        }

        return redirect()->route('inventory.index');
    }

    public function render()
    {
        return view('livewire.inventory.inventory-form', [
            'departamentos' => Departamento::all(),
            'sucursales' => Sucursal::where('activa', true)->get(),
        ])->layout('layouts.app');
    }
}
