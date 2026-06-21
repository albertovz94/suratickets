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
        $this->ticket = $ticket->load(['sucursal', 'creator', 'assignedTo']);
        
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
        
        \App\Models\ActivityLog::log('Actualizar Estado Ticket', "Se cambió el estado del ticket #{$this->ticket->id} a {$this->status}", $this->ticket);
        
        // Enviar notificación si se resuelve o cierra
        if (in_array($this->status, ['resuelto', 'cerrado'])) {
            $creatorName = $this->ticket->creator->name;
            $deptName = optional($this->ticket->creator->departamento)->nombre ?? 'Sin departamento';
            $resolverName = \Illuminate\Support\Facades\Auth::user()->name;
            $message = "El ticket #{$this->ticket->id} de {$creatorName} ({$deptName}) ha sido marcado como " . ucfirst($this->status) . " por {$resolverName}.";
            
            // Notificar al creador del ticket
            \Illuminate\Support\Facades\Notification::send($this->ticket->creator, new \App\Notifications\TicketCreated($this->ticket, $message));
            
            // Notificar a todos los administradores
            $admins = \App\Models\User::where('rol', 'admin')->get();
            \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\TicketCreated($this->ticket, $message));
        }

        $this->dispatch('ticket-saved');
    }

    public function updatedAssignedTo()
    {
        $this->authorize('update', $this->ticket);

        $this->validate([
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $this->ticket->update(['assigned_to' => $this->assigned_to ?: null]);
        \App\Models\ActivityLog::log('Asignar Ticket', "Se asignó el ticket #{$this->ticket->id}", $this->ticket);
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
            
            // Enviar notificaciones
            $creatorName = $this->ticket->creator->name;
            $deptName = optional($this->ticket->creator->departamento)->nombre ?? 'Sin departamento';
            $resolverName = \Illuminate\Support\Facades\Auth::user()->name;
            $message = "El ticket #{$this->ticket->id} de {$creatorName} ({$deptName}) ha sido marcado como Resuelto por {$resolverName}.";
            
            \Illuminate\Support\Facades\Notification::send($this->ticket->creator, new \App\Notifications\TicketCreated($this->ticket, $message));
            
            $admins = \App\Models\User::where('rol', 'admin')->get();
            \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\TicketCreated($this->ticket, $message));
        }

        // Refrescar para que la vista detecte el cambio de estado si ocurrió
        $this->ticket->refresh();
        $this->dispatch('ticket-saved');
    }

    #[Computed]
    public function admins()
    {
        return User::where('rol', 'admin')->get();
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

        \App\Models\ActivityLog::log('Comentar Ticket', "Se agregó un comentario al ticket #{$this->ticket->id}", $this->ticket);

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
