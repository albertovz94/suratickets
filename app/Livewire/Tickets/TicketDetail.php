<?php

namespace App\Livewire\Tickets;

use Livewire\Component;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Notifications\TicketStatusUpdatedNotification;
use Livewire\Attributes\On;

class TicketDetail extends Component
{
    public ?Ticket $ticket = null;
    public $assigned_to;
    public $resolution_summary;
    public bool $showDetailModal = false;

    #[On('open-ticket-modal')]
    public function loadTicket($ticketId)
    {
        $this->ticket = Ticket::with(['sucursal', 'creator', 'assignedTo'])->findOrFail($ticketId);
        
        // Autorizar visualización usando TicketPolicy
        $this->authorize('view', $this->ticket);

        // Automatización: Si es admin y el ticket está abierto, pasarlo a en proceso
        if (Auth::user()->rol === 'admin' && $this->ticket->status === 'abierto') {
            $this->ticket->update(['status' => 'en_proceso']);
            $this->ticket->refresh();
        }

        $this->assigned_to = $this->ticket->assigned_to;
        $this->resolution_summary = $this->ticket->resolution_summary;
        $this->showDetailModal = true;
    }

    public function closeModal()
    {
        $this->showDetailModal = false;
        $this->ticket = null;
    }

    public function updateTicket()
    {
        if (!$this->ticket) return;

        // Autorizar actualización usando TicketPolicy
        $this->authorize('update', $this->ticket);

        $this->validate([
            'assigned_to' => 'nullable|exists:users,id',
            'resolution_summary' => 'nullable|string',
        ]);

        // Automatización: Si escribe resolución, se resuelve. Si no, sigue en proceso.
        $newStatus = $this->resolution_summary ? 'resuelto' : 'en_proceso';

        $this->ticket->update([
            'status' => $newStatus,
            'assigned_to' => $this->assigned_to,
            'resolution_summary' => $this->resolution_summary,
        ]);

        // Enviar notificación al creador si alguien más lo modificó
        if ($this->ticket->creator_id !== Auth::id()) {
            $message = "El estado de tu ticket ha cambiado a: " . ucfirst(str_replace('_', ' ', $newStatus));
            $this->ticket->creator->notify(new TicketStatusUpdatedNotification($this->ticket, $message));
        }

        $this->dispatch('ticket-updated');
        $this->closeModal();
    }

    public function render()
    {
        $admins = User::where('rol', 'admin')->get();

        return view('livewire.tickets.ticket-detail', [
            'admins' => $admins
        ]);
    }
}
