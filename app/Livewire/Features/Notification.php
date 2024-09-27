<?php

namespace App\Livewire\Features;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Notification extends Component
{
    public function render()
    {
        return view('livewire.features.notification', [
            'notifications' => Auth::user()->notifications()->with('notifiable')->get(),
            'unreadNotificationsCount' => Auth::user()->unreadNotifications->count(),
        ]);
    }


    public function markAsRead($notificationId)
    {
        $notification = Auth::user()->notifications()->find($notificationId);
        if ($notification) {
            $notification->markAsRead();
        }
    }

    public function deleteNotification($notificationId)
    {
        $notification = Auth::user()->notifications()->find($notificationId);
        if ($notification) {
            $notification->delete();
        }
    }
}
