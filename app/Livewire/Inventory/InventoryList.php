<?php

namespace App\Livewire\Inventory;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Equipo;

class InventoryList extends Component
{
    use WithPagination;

    public $search = '';
    public $type = '';
    public $status = '';
    public $sucursal_id = '';
    public $departamento_id = '';

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

    public function render()
    {
        $query = Equipo::query();

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

        if ($this->sucursal_id) {
            $query->where('sucursal_id', $this->sucursal_id);
        }

        if ($this->departamento_id) {
            $query->where('departamento_id', $this->departamento_id);
        }

        // Fake stats based on mock
        $totalEquipos = 142; // Real: Equipo::count();
        $activos = 128; // Real: Equipo::where('status', 'Activo')->count();
        $enReparacion = 9; // Real: Equipo::where('status', 'En reparacion')->count();
        $dadosBaja = 5; // Real: Equipo::where('status', 'De baja')->count();

        // Unique values for dropdowns
        $types = Equipo::select('type')->distinct()->pluck('type');
        $statuses = Equipo::select('status')->distinct()->pluck('status');
        $sucursales = \App\Models\Sucursal::where('activa', true)->get();
        $departamentos = \App\Models\Departamento::all();

        return view('livewire.inventory.inventory-list', [
            'equipos' => $query->paginate(6),
            'totalEquipos' => $totalEquipos,
            'activos' => $activos,
            'enReparacion' => $enReparacion,
            'dadosBaja' => $dadosBaja,
            'types' => $types,
            'statuses' => $statuses,
            'sucursales' => $sucursales,
            'departamentos' => $departamentos,
        ])->layout('layouts.app');
    }
}
