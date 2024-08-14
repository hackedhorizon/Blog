<?php

namespace App\Notifications;

use App\Broadcasting\DatabaseChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class SuccessfulRegistrationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        $this->onQueue('database.notifications');
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [DatabaseChannel::class];
    }

    /**
     * Get the notification's content.
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => __('notifications.registration.welcome'),
            'message' => __('notifications.registration.success', ['username' => $notifiable->name]),
        ];
    }
}
