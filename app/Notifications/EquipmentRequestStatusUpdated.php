<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use App\Models\EquipmentRequest;

class EquipmentRequestStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    public $request;
    public $message;

    public function __construct(EquipmentRequest $request, $message)
    {
        $this->request = $request;
        $this->message = $message;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'request_id' => $this->request->id,
            'message' => $this->message,
            'status' => $this->request->status,
        ];
    }
}
