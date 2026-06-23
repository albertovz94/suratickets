<?php

namespace App\Observers;

use App\Models\Ticket;
use App\Models\User;
use App\Notifications\TicketCriticoNotification;
use Illuminate\Support\Facades\Notification;

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
        if ($ticket->priority === 'critica') {
            $admins = User::where('rol', 'admin')->get();
            Notification::send($admins, new TicketCriticoNotification($ticket));
        }
    }

    /**
     * Handle the Ticket "updated" event.
     */
    public function updated(Ticket $ticket): void
    {
        if ($ticket->isDirty('priority') && $ticket->priority === 'critica') {
            $admins = User::where('rol', 'admin')->get();
            Notification::send($admins, new TicketCriticoNotification($ticket));
        }
    }
}
