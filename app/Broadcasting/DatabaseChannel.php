<?php

namespace App\Broadcasting;

use Illuminate\Notifications\Channels\DatabaseChannel as DBO;
use Illuminate\Notifications\Notification;

class DatabaseChannel extends DBO
{
    /**
     * Build an array payload for the DatabaseNotification Model.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    protected function buildPayload($notifiable, Notification $notification)
    {
        return [
            'id' => $notification->id,
            'type' => get_class($notification),
            'data' => ['data' => serialize($notification)],
            'read_at' => null,
            'serialized' => true,
        ];
    }
}
