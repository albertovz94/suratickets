<?php

namespace App\Livewire\Layout;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationBell extends Component
{
    public $notifications;
    public $unreadCount;
    public $isOpen = false;

    // Actualiza la cuenta cada 30 segundos
    protected $listeners = ['echo:private-App.Models.User.' . 'id' . ',Illuminate\\Notifications\\Events\\BroadcastNotificationCreated' => 'loadNotifications'];

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

            $latest = Auth::user()->unreadNotifications()->first();
            if ($latest && $latest->id !== $this->lastNotificationId) {
                // If this isn't the first load, trigger the toast
                if ($this->lastNotificationId !== null) {
                    $this->dispatch('show-toast', message: $latest->data['message']);
                }
                $this->lastNotificationId = $latest->id;
            }
        } else {
            $this->notifications = collect();
            $this->unreadCount = 0;
        }
    }

    public function toggle()
    {
        $this->isOpen = !$this->isOpen;
    }

    public function markAsRead($notificationId, $ticketId = null)
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

        if ($notification->type === \App\Notifications\PasswordResetAdminNotification::class) {
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
