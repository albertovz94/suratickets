<?php

namespace App\Livewire\Solicitudes;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Solicitud;

class SolicitudList extends Component
{
    use WithPagination;

    public $activeTab = 'pendiente'; // Tabs: pendiente, aprobado, rechazado

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage(); // Volver a la primera página al cambiar de pestaña
    }

    public function updateStatus($id, $newStatus)
    {
        if (auth()->user()->rol !== 'admin') {
            abort(403);
        }

        $solicitud = Solicitud::findOrFail($id);
        $solicitud->update(['estado' => $newStatus]);
        
        session()->flash('message', "Solicitud #{$id} marcada como {$newStatus}.");
    }

    public function render()
    {
        $query = Solicitud::query();

        // Filtrar por la pestaña activa
        if ($this->activeTab === 'aprobado') {
            // Mostrar aprobado o entregado si se considera que todo lo que no es pendiente o rechazado está aquí
            $query->whereIn('estado', ['aprobado', 'entregado']);
        } else {
            $query->where('estado', $this->activeTab);
        }

        if (auth()->user()->rol === 'admin') {
            $solicitudes = $query->with('user')->latest()->paginate(15);
        } else {
            $solicitudes = $query->where('user_id', auth()->id())->latest()->paginate(15);
        }

        return view('livewire.solicitudes.solicitud-list', [
            'solicitudes' => $solicitudes
        ])->layout('layouts.app');
    }
}
