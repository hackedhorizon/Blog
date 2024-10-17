<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\App;
use Laravel\Scout\Searchable;

class Post extends Model
{
    use HasFactory, Searchable;

    protected $fillable = ['user_id', 'title', 'body', 'is_published', 'published_at', 'is_featured'];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    // Relations

    public function translations(): HasMany
    {
        return $this->hasMany(PostTranslation::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Local scope filters

    public function scopeByAuthor($query, $authorId)
    {
        return $query->where('author_id', $authorId);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    public function scopeByRelated($query, $postId)
    {
        return $query->where('category_id', $postId)->where('id', '!=', $postId);
    }

    // Helper functions

    public function getTranslation($locale)
    {
        return $this->translations()->where('locale', $locale)->first();
    }

    // Accessors

    public function getTranslatedTitleAttribute()
    {
        $locale = App::getLocale();
        $translation = $this->getTranslation($locale);

        return $translation ? $translation->title : $this->title;
    }

    public function getTranslatedBodyAttribute()
    {
        $locale = App::getLocale();
        $translation = $this->getTranslation($locale);

        return $translation ? $translation->body : $this->body;
    }

    public function toSearchableArray()
    {
        return [
            'title' => $this->translatedTitle,
            'body' => $this->translatedBody,
        ];
    }
}
