<?php

namespace App\Models;

class DatabaseNotification extends \Illuminate\Notifications\DatabaseNotification
{
    // Override default DatabaseNotification model to unserialize data to display the translated notification for the user.
    public function getDataAttribute()
    {
        if (isset($this->attributes['data'])) {
            $data = json_decode($this->attributes['data'], true);

            if (isset($this->attributes['serialized']) && $this->attributes['serialized']) {
                $obj = unserialize($data['data']);
                if (method_exists($obj, 'toDatabase')) {
                    // Use the preloaded notifiable if available
                    return $obj->toDatabase($this->relationLoaded('notifiable') ? $this->notifiable : null);
                } else {
                    return $obj->toArray($this->relationLoaded('notifiable') ? $this->notifiable : null);
                }
            } else {
                return $data;
            }
        }

        return [];
    }
}
