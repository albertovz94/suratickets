<?php

namespace App\Observers;

use App\Models\Ticket;
use App\Models\User;
use App\Notifications\TicketCriticoNotification;
use App\Notifications\TicketCreated;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;

class TicketObserver
{
    /**
     * Handle the Ticket "updating" event.
     */
    public function updating(Ticket $ticket): void
    {
        if ($ticket->isDirty('status')) {
            if (in_array($ticket->status, ['resuelto', 'cerrado'])) {
                $ticket->resolved_at = now();
            } else {
                $ticket->resolved_at = null; // En caso de que se reabra el ticket
            }
        }
    }

    /**
     * Handle the Ticket "created" event.
     */
    public function created(Ticket $ticket): void
    {
        $admins = User::admins()->get();

        if ($ticket->priority === 'critica') {
            Notification::send($admins, new TicketCriticoNotification($ticket));
        } else {
            $assignedName = $ticket->assignedTo ? $ticket->assignedTo->name : 'Sin técnico asignado';
            $message = "Nuevo ticket reportado. Asignado automáticamente a: " . $assignedName;
            Notification::send($admins, new TicketCreated($ticket, $message));
        }
    }

    /**
     * Handle the Ticket "updated" event.
     */
    public function updated(Ticket $ticket): void
    {
        if ($ticket->wasChanged('priority') && $ticket->priority === 'critica') {
            $admins = User::admins()->get();
            Notification::send($admins, new TicketCriticoNotification($ticket));
        }

        // Si el estado cambió a resuelto o cerrado
        if ($ticket->wasChanged('status') && in_array($ticket->status, ['resuelto', 'cerrado'])) {
            // Asegurarse de que no estuviese ya en estado de resolución
            if (!in_array($ticket->getOriginal('status'), ['resuelto', 'cerrado'])) {
                $creatorName = $ticket->creator->name;
                $deptName = optional($ticket->creator->department)->name ?? 'Sin departamento';
                $resolverName = Auth::check() ? Auth::user()->name : 'el Sistema';
                
                $message = "El ticket #{$ticket->id} de {$creatorName} ({$deptName}) ha sido marcado como " . ucfirst($ticket->status) . " por {$resolverName}.";
                
                Notification::send($ticket->creator, new TicketCreated($ticket, $message));
                
                $admins = User::admins()->get();
                Notification::send($admins, new TicketCreated($ticket, $message));
            }
        }
    }
}
