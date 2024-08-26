<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class PostTranslation extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'post_id',
        'locale',
        'title',
        'body',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // Specify the fields to be indexed by Scout
    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
            'locale' => $this->locale,
        ];
    }
}
