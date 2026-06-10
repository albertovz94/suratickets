<?php

namespace App\Livewire\Tickets;

use Livewire\Component;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TicketDetail extends Component
{
    public Ticket $ticket;
    public $status;
    public $assigned_to;
    public $resolution_summary;

    public function mount(Ticket $ticket)
    {
        $this->ticket = $ticket->load(['sucursal', 'creator', 'assignedTo']);
        
        // Autorizar visualización usando TicketPolicy
        $this->authorize('view', $this->ticket);

        $this->status = $ticket->status;
        $this->assigned_to = $ticket->assigned_to;
        $this->resolution_summary = $ticket->resolution_summary;
    }

    public function updateTicket()
    {
        // Autorizar actualización usando TicketPolicy
        $this->authorize('update', $this->ticket);

        $this->validate([
            'status' => 'required|in:abierto,asignado,en_proceso,pendiente,resuelto,cerrado',
            'assigned_to' => 'nullable|exists:users,id',
            'resolution_summary' => 'nullable|string',
        ]);

        $this->ticket->update([
            'status' => $this->status,
            'assigned_to' => $this->assigned_to,
            'resolution_summary' => $this->resolution_summary,
        ]);

        session()->flash('message', 'Ticket actualizado exitosamente.');
        
        // Refrescar el modelo
        $this->ticket->refresh();
    }

    public function render()
    {
        $admins = User::where('rol', 'admin')->get();

        return view('livewire.tickets.ticket-detail', [
            'admins' => $admins
        ])->layout('layouts.app');
    }
}
