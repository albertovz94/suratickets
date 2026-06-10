<?php

namespace App\Livewire\Tickets;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class TicketList extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    public $priority = '';
    public $activeTab = 'activos';

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Ticket::with(['sucursal', 'creator', 'assignedTo'])
            ->when($this->search, function ($q) {
                $q->where(function($query) {
                    $query->where('title', 'like', '%' . $this->search . '%')
                          ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->status, function ($q) {
                $q->where('status', $this->status);
            })
            ->when($this->priority, function ($q) {
                $q->where('priority', $this->priority);
            });

        if ($this->activeTab === 'activos') {
            $query->whereNotIn('status', ['cerrado', 'resuelto']);
        } else {
            $query->whereIn('status', ['cerrado', 'resuelto']);
        }

        if (Auth::user()->rol !== 'admin') {
            $query->where('creator_id', Auth::id());
        }

        $tickets = $query->latest()->paginate(10);

        return view('livewire.tickets.ticket-list', [
            'tickets' => $tickets
        ]);
    }
}
