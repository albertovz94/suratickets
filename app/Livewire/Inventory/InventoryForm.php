<?php

namespace App\Livewire\Inventory;

use Livewire\Component;
use App\Models\Device;
use App\Models\Department;
use App\Models\Branch;

class InventoryForm extends Component
{
    public $device_id;
    public $name = '';
    public $specs = '';
    public $type = 'Laptop';
    public $serial_number = '';
    public $branch_id = '';
    public $department_id = '';
    public $status = 'Activo';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'specs' => 'nullable|string|max:255',
            'type' => 'required|in:Laptop,Desktop,Servidor,Red,Impresora,Otro',
            'serial_number' => 'required|string|unique:devices,serial_number,' . $this->device_id,
            'branch_id' => 'nullable|exists:branches,id',
            'department_id' => 'nullable|exists:departments,id',
            'status' => 'required|in:Activo,En reparacion,De baja',
        ];
    }

    public function mount($id = null)
    {
        if ($id) {
            $device = Device::findOrFail($id);
            $this->device_id = $device->id;
            $this->name = $device->name;
            $this->specs = $device->specs;
            $this->type = $device->type;
            $this->serial_number = $device->serial_number;
            $this->branch_id = $device->branch_id;
            $this->department_id = $device->department_id;
            $this->status = $device->status;
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
            'branch_id' => $this->branch_id ?: null,
            'department_id' => $this->department_id ?: null,
            'status' => $this->status,
        ];

        if ($this->device_id) {
            Device::where('id', $this->device_id)->update($data);
            $this->dispatch('notify', message: 'Equipo actualizado correctamente.'); session()->flash('message', 'Equipo actualizado correctamente.');
        } else {
            Device::create($data);
            $this->dispatch('notify', message: 'Equipo creado correctamente.'); session()->flash('message', 'Equipo creado correctamente.');
        }

        return redirect()->route('inventory.index');
    }

    public function render()
    {
        return view('livewire.inventory.inventory-form', [
            'departments' => Department::all(),
            'branches' => Branch::where('is_active', true)->get(),
        ])->layout('layouts.app');
    }
}
