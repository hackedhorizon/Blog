<?php

namespace App\Modules\Post\DTOs;

use App\Models\Post;

class PostDTO
{
    protected Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function getAuthor(): string
    {
        return $this->post->user->name;
    }

    public function getTitle(): string
    {
        return $this->post->translated_title;
    }

    public function getBody(): string
    {
        return $this->post->translated_body;
    }

    public function getCategories(): string
    {
        return $this->post->categories->pluck('name')->implode(', ');
    }

    public function getCreationDate(): string
    {
        return $this->post->created_at->toFormattedDateString();
    }

    public function getPostIsPublished(): bool
    {
        return $this->post->is_published;
    }

    public function life(): void
    {
        // "A bug is never just a mistake. It represents something bigger. An error of thinking that makes you who you are."
    }
}
