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
    public $assigned_to = null;
    public $userSearch = '';

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
            'assigned_to' => 'nullable|exists:users,id',
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
            $this->assigned_to = $device->assigned_to;
            
            if ($device->assigned_to && $device->assignee) {
                $this->userSearch = trim($device->assignee->name . ' ' . ($device->assignee->last_name ?? ''));
            }
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
            'assigned_to' => $this->assigned_to ?: null,
        ];

        if ($this->device_id) {
            Device::where('id', $this->device_id)->update($data);
            $device = Device::find($this->device_id);
            \App\Services\ActivityLogger::log('update_device', $device, "Actualizó la información del equipo {$device->name} (S/N: {$device->serial_number})");
            session()->flash('message', 'Equipo actualizado correctamente.');
        } else {
            $device = Device::create($data);
            \App\Services\ActivityLogger::log('create_device', $device, "Creó el equipo {$device->name} (S/N: {$device->serial_number}) del tipo {$device->type}");
            session()->flash('message', 'Equipo creado correctamente.');
        }

        \Illuminate\Support\Facades\Cache::forget('inventory_stats');
        \Illuminate\Support\Facades\Cache::forget('inventory_dropdowns');

        return redirect()->route('inventory.index');
    }

    public function render()
    {
        $users = [];
        if (!empty(trim($this->userSearch))) {
            $users = \App\Models\User::with('department')
                ->where(function($query) {
                    $query->where('name', 'like', '%' . $this->userSearch . '%')
                          ->orWhere('last_name', 'like', '%' . $this->userSearch . '%')
                          ->orWhere('username', 'like', '%' . $this->userSearch . '%')
                          ->orWhereHas('department', function($q) {
                              $q->where('name', 'like', '%' . $this->userSearch . '%');
                          });
                })->limit(10)->get();
        }

        return view('livewire.inventory.inventory-form', [
            'departments' => Department::all(),
            'branches' => Branch::where('is_active', true)->get(),
            'users' => $users,
        ])->layout('layouts.app');
    }
}
