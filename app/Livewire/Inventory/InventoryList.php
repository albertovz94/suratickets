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

    public function updatingBranchId()
    {
        $this->resetPage();
    }

    public function updatingDepartmentId()
    {
        $this->resetPage();
    }

    public function deleteEquipo($id)
    {
        $device = Device::findOrFail($id);
        $device->delete();
        \App\Services\ActivityLogger::log('delete_device', $device, "Eliminó el equipo {$device->name} (S/N: {$device->serial_number})");
        \Illuminate\Support\Facades\Cache::forget('inventory_stats');
        \Illuminate\Support\Facades\Cache::forget('inventory_dropdowns_v3');
        $this->dispatch('notify', message: 'Equipo eliminado correctamente.');
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
        \Illuminate\Support\Facades\Cache::forget('inventory_stats');
        $this->dispatch('notify', message: $message);
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

        // Estadísticas Reales cacheadas por 5 min
        $stats = \Illuminate\Support\Facades\Cache::remember('inventory_stats', 300, function() {
            return [
                'total' => Device::count(),
                'activos' => Device::where('status', 'Activo')->count(),
                'enReparacion' => Device::where('status', 'En reparacion')->count(),
                'dadosBaja' => Device::where('status', 'De baja')->count(),
            ];
        });

        // Unique values for dropdowns cacheadas por 1 hora
        $dropdowns = \Illuminate\Support\Facades\Cache::remember('inventory_dropdowns_v3', 3600, function() {
            return [
                'types' => Device::select('type')->distinct()->pluck('type')->toArray(),
                'statuses' => Device::select('status')->distinct()->pluck('status')->toArray(),
                'branches' => \App\Models\Branch::where('is_active', true)->select('id', 'name')->get()->toArray(),
                'departments' => \App\Models\Department::select('id', 'name')->get()->toArray(),
            ];
        });

        return view('livewire.inventory.inventory-list', [
            'devices' => $query->with(['branch', 'department'])->paginate(6),
            'totalEquipos' => $stats['total'],
            'activos' => $stats['activos'],
            'enReparacion' => $stats['enReparacion'],
            'dadosBaja' => $stats['dadosBaja'],
            'types' => $dropdowns['types'],
            'statuses' => $dropdowns['statuses'],
            'branches' => $dropdowns['branches'],
            'departments' => $dropdowns['departments'],
        ])->layout('layouts.app');
    }
}
