<?php

namespace App\Notifications;

use App\Broadcasting\DatabaseChannel;
use DragonCode\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PostPublishedNotification extends Notification implements ShouldQueue
{
    use Queueable;
    private $title;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $title)
    {
        $this->title = $title;
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
            'title' => __('notifications.queue.post_published_title'),
            'message' => __('notifications.queue.post_published_description', ['title' => $this->title]),
        ];
    }
}
