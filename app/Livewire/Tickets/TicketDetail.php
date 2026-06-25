<?php

namespace App\Livewire\Tickets;

use Livewire\Component;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;

use Livewire\WithFileUploads;

class TicketDetail extends Component
{
    use WithFileUploads;

    public Ticket $ticket;
    public $status;
    public $assigned_to;
    public $resolution_summary; // This can stay for backward compatibility or be removed if not used
    public $newMessage = '';
    public $attachment;

    public function mount(Ticket $ticket)
    {
        $this->ticket = $ticket->load(['branch', 'creator', 'assignedTo']);
        
        // Autorizar visualización usando TicketPolicy
        $this->authorize('view', $this->ticket);

        $this->status = $ticket->status;
        $this->assigned_to = $ticket->assigned_to;
        $this->resolution_summary = $ticket->resolution_summary;
    }

    public function updatedStatus()
    {
        $this->authorize('update', $this->ticket);
        
        $this->validate([
            'status' => 'required|in:abierto,asignado,en_proceso,pendiente,resuelto,cerrado',
        ]);

        $this->ticket->update(['status' => $this->status]);
        
        $this->dispatch('ticket-saved');
    }

    public function updatedAssignedTo()
    {
        $this->authorize('update', $this->ticket);

        $this->validate([
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $this->ticket->update(['assigned_to' => $this->assigned_to ?: null]);

        $this->dispatch('ticket-saved');
    }

    public function updatedResolutionSummary()
    {
        $this->authorize('update', $this->ticket);

        $this->validate([
            'resolution_summary' => 'nullable|string|max:2000',
        ]);

        $this->ticket->update(['resolution_summary' => $this->resolution_summary]);
        
        // Auto-resolver si se escribió algo y el ticket no está ya resuelto o cerrado
        if (!empty(trim($this->resolution_summary)) && !in_array($this->status, ['resuelto', 'cerrado'])) {
            $this->status = 'resuelto';
            $this->ticket->update(['status' => 'resuelto']);
            // El Observer se encargará de enviar las notificaciones
        }

        // Refrescar para que la vista detecte el cambio de estado si ocurrió
        $this->ticket->refresh();
        $this->dispatch('ticket-saved');
    }

    #[Computed]
    public function admins()
    {
        return User::admins()->get();
    }

    #[Computed]
    public function ticketMessages()
    {
        return $this->ticket->messages()->with('user')->get();
    }

    public function sendMessage()
    {
        $this->validate([
            'newMessage' => 'required|string|max:2000',
            'attachment' => 'nullable|file|max:10240', // Max 10MB
        ]);

        $path = null;
        if ($this->attachment) {
            $path = $this->attachment->store('attachments', 'public');
        }

        $this->ticket->messages()->create([
            'user_id' => Auth::id(),
            'message' => $this->newMessage,
            'attachment_path' => $path,
        ]);



        $this->newMessage = '';
        $this->attachment = null;
        $this->ticket->refresh();
    }

    public function render()
    {
        return view('livewire.tickets.ticket-detail', [
            'admins' => $this->admins()
        ])->layout('layouts.app');
    }
}
