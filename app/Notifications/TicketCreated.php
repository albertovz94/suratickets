<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Ticket;

class TicketCreated extends Notification
{
    use Queueable;

    public $ticket;
    public $message;

    /**
     * Create a new notification instance.
     */
    public function __construct(Ticket $ticket, $message = null)
    {
        $this->ticket = $ticket;
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'ticket_id' => $this->ticket->id,
            'title' => $this->ticket->title,
            'assigned_to_name' => $this->ticket->assignedTo ? $this->ticket->assignedTo->name : 'Nadie',
            'message' => $this->message ?? 'Nuevo ticket reportado.',
            'creator_name' => $this->ticket->creator->name,
        ];
    }
}
