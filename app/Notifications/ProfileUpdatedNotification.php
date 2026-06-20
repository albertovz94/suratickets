<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class ProfileUpdatedNotification extends Notification
{
    use Queueable;

    protected $message;

    public function __construct($message = 'Tu perfil ha sido actualizado con éxito.')
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->message,
            'type' => 'success',
        ];
    }
}
