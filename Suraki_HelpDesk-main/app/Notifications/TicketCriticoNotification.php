<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Ticket;

class TicketCriticoNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $ticket;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'ticket_id' => $this->ticket->id,
            'message' => '🚨 Ticket CRÍTICO Reportado: ' . $this->ticket->title,
            'status' => $this->ticket->status,
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('🚨 Ticket CRÍTICO Reportado: ' . $this->ticket->title)
                    ->greeting('Hola Equipo de Sistemas,')
                    ->line('Se ha reportado un nuevo problema crítico en la sucursal: ' . $this->ticket->sucursal->nombre)
                    ->line('**Área:** ' . $this->ticket->area_departamento)
                    ->line('**Equipo:** ' . $this->ticket->equipo_afectado)
                    ->line('**Descripción:** ' . $this->ticket->description)
                    ->action('Ver Ticket', url('/dashboard'))
                    ->line('Por favor, atienda este requerimiento lo antes posible.');
    }
}
