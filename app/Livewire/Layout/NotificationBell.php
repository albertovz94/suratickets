<?php

namespace App\Livewire\Layout;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationBell extends Component
{
    public $notifications;
    public $unreadCount;
    public $isOpen = false;

    // Actualiza la cuenta cada 30 segundos (Vía wire:poll en la vista, se remueve el listener de Echo que causaba error)
    // protected $listeners = ['echo:private-App.Models.User.' . 'id' . ',Illuminate\\Notifications\\Events\\BroadcastNotificationCreated' => 'loadNotifications'];

    public function mount()
    {
        $this->loadNotifications();
    }

    public $lastNotificationId = null;

    public function loadNotifications()
    {
        if (Auth::check()) {
            $this->notifications = Auth::user()->notifications()->take(5)->get();
            $this->unreadCount = Auth::user()->unreadNotifications()->count();

            // Mostrar toast solo si hay una nueva notificación que aún no se ha visto en esta sesión
            $latest = Auth::user()->unreadNotifications()->first();
            if ($latest && session('lastNotificationId') !== $latest->id) {
                $this->dispatch('notify', message: $latest->data['message'] ?? 'Nueva notificación');
                session(['lastNotificationId' => $latest->id]);
            }
        } else {
            $this->notifications = collect();
            $this->unreadCount = 0;
        }
    }

    public function sendTestPush()
    {
        $this->dispatch('browser-push', [
            'title' => '🧪 Notificación de Prueba Suraki',
            'body' => '¡Excelente! Las notificaciones Push en tu navegador y dispositivo funcionan correctamente.'
        ]);
        $this->dispatch('notify', message: 'Notificación de prueba enviada.');
    }

    public function toggle()
    {
        $this->isOpen = !$this->isOpen;
    }

    public function markAsRead($notificationId, $ticketId = null, $requestId = null)
    {
        $notification = Auth::user()->notifications()->find($notificationId);
        if ($notification) {
            $notification->markAsRead();
        }
        $this->loadNotifications();
        $this->isOpen = false;

        if ($ticketId) {
            return redirect()->route('tickets.show', $ticketId);
        }

        if ($requestId) {
            return redirect()->route('requests.index');
        }

        if ($notification && $notification->type === \App\Notifications\PasswordResetAdminNotification::class) {
            return redirect()->route('users.index');
        }
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.layout.notification-bell');
    }
}
