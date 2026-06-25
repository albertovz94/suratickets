<?php

namespace App\Livewire\Inventory;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Device;

class InventoryList extends Component
{
    use WithPagination;

    public $search = '';
    public $type = '';
    public $status = '';
    public $branch_id = '';
    public $department_id = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingType()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function updatingSucursalId()
    {
        $this->resetPage();
    }

    public function updatingDepartamentoId()
    {
        $this->resetPage();
    }

    public function deleteEquipo($id)
    {
        $device = Device::findOrFail($id);
        $device->delete();
        $this->dispatch('notify', message: 'Equipo eliminado correctamente.'); session()->flash('message', 'Equipo eliminado correctamente.');
    }

    public function cycleEquipoStatus($id)
    {
        $device = Device::findOrFail($id);
        
        if ($device->status === 'Activo') {
            $device->status = 'En reparacion';
            $message = "El equipo {$device->name} ahora está en reparación.";
        } elseif ($device->status === 'En reparacion') {
            $device->status = 'De baja';
            $message = "El equipo {$device->name} ha sido dado de baja.";
        } else {
            $device->status = 'Activo';
            $message = "El equipo {$device->name} ahora está activo.";
        }
        
        $device->save();
        $this->dispatch('show-toast', message: $message);
    }

    public function render()
    {
        $query = Device::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('specs', 'like', '%' . $this->search . '%')
                  ->orWhere('serial_number', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->type) {
            $query->where('type', $this->type);
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        if ($this->branch_id) {
            $query->where('branch_id', $this->branch_id);
        }

        if ($this->department_id) {
            $query->where('department_id', $this->department_id);
        }

        // Estadísticas Reales
        $totalEquipos = Device::count();
        $activos = Device::where('status', 'Activo')->count();
        $enReparacion = Device::where('status', 'En reparacion')->count();
        $dadosBaja = Device::where('status', 'De baja')->count();

        // Unique values for dropdowns
        $types = Device::select('type')->distinct()->pluck('type');
        $statuses = Device::select('status')->distinct()->pluck('status');
        $branches = \App\Models\Branch::where('is_active', true)->get();
        $departments = \App\Models\Department::all();

        return view('livewire.inventory.inventory-list', [
            'devices' => $query->paginate(6),
            'totalEquipos' => $totalEquipos,
            'activos' => $activos,
            'enReparacion' => $enReparacion,
            'dadosBaja' => $dadosBaja,
            'types' => $types,
            'statuses' => $statuses,
            'branches' => $branches,
            'departments' => $departments,
        ])->layout('layouts.app');
    }
}
