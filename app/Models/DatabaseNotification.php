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
                    return unserialize($data['data'])->toDatabase($this->notifiable);
                } else {
                    return unserialize($data['data'])->toArray($this->notifiable);
                }
            } else {
                return $data;
            }
        }

        return [];
    }
}
