<?php

namespace App\Livewire\Requests;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Request;

class RequestList extends Component
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
        if (!auth()->user()->hasAdminAccess()) {
            abort(403);
        }

        $solicitud = Request::findOrFail($id);
        $solicitud->update(['status' => $newStatus]);
        
        $this->dispatch('notify', message: "Solicitud #{$id} marcada como {$newStatus}."); session()->flash('message', "Solicitud #{$id} marcada como {$newStatus}.");
    }

    public function render()
    {
        $query = Request::query();

        // Filtrar por la pestaña activa
        if ($this->activeTab === 'aprobado') {
            // Mostrar aprobado o entregado si se considera que todo lo que no es pendiente o rechazado está aquí
            $query->whereIn('status', ['aprobado', 'entregado']);
        } else {
            $query->where('status', $this->activeTab);
        }

        if (auth()->user()->hasAdminAccess()) {
            $solicitudes = $query->with('user', 'assignedTo')->latest()->paginate(15);
        } else {
            $solicitudes = $query->where('user_id', auth()->id())->with('user', 'assignedTo')->latest()->paginate(15);
        }

        return view('livewire.requests.request-list', [
            'solicitudes' => $solicitudes
        ])->layout('layouts.app');
    }
}
