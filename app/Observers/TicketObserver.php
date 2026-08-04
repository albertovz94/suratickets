<?php

namespace App\Observers;

use App\Models\Ticket;
use App\Models\User;
use App\Notifications\TicketCriticoNotification;
use App\Notifications\TicketCreated;
use App\Services\TelegramService;
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
        // Obtener admins, excluyendo al creador del ticket para no duplicar notificaciones
        $creatorId = $ticket->user_id ?? (Auth::check() ? Auth::id() : null);
        $admins = User::admins()->when($creatorId, fn($q) => $q->where('id', '!=', $creatorId))->get();

        if ($ticket->priority === 'critica') {
            Notification::send($admins, new TicketCriticoNotification($ticket));
        } else {
            $assignedName = $ticket->assignedTo ? $ticket->assignedTo->name : 'Sin técnico asignado';
            $message = "Nuevo ticket reportado. Asignado automáticamente a: " . $assignedName;
            Notification::send($admins, new TicketCreated($ticket, $message));
        }

        // Notificación automática por Telegram
        TelegramService::sendTicketNotification($ticket, 'created');
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
                
                // Notificar al creador del ticket
                Notification::send($ticket->creator, new TicketCreated($ticket, $message));
                
                // Notificar a admins, excluyendo al creador (ya notificado arriba) y al resolutor
                $excludeIds = [$ticket->creator->id];
                if (Auth::check()) {
                    $excludeIds[] = Auth::id();
                }
                $admins = User::admins()->whereNotIn('id', $excludeIds)->get();
                Notification::send($admins, new TicketCreated($ticket, $message));

                // Notificación por Telegram al resolver
                TelegramService::sendTicketNotification($ticket, 'resolved');
            }
        }
    }
}
