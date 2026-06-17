<?php

namespace App\Livewire\Layout;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationBell extends Component
{
    public $unreadCount = 0;

    public function mount()
    {
        $this->updateCount();
    }

    public function updateCount()
    {
        if (Auth::check()) {
            $this->unreadCount = Auth::user()->unreadNotifications()->count();
        }
    }

    public function markAsRead()
    {
        if (Auth::check()) {
            Auth::user()->unreadNotifications->markAsRead();
            $this->updateCount();
        }
    }

    public function render()
    {
        $notifications = collect();
        if (Auth::check()) {
            $notifications = Auth::user()->notifications()->take(10)->get();
        }

        return view('livewire.layout.notification-bell', [
            'notifications' => $notifications
        ]);
    }
}
