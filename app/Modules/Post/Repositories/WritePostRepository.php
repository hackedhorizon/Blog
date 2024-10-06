<?php

namespace App\Modules\Post\Repositories;

use App\Models\Post;
use App\Models\PostTranslation;
use App\Modules\Post\DTOs\PostCreateDTO;
use App\Modules\Post\Interfaces\WritePostRepositoryInterface;

class WritePostRepository implements WritePostRepositoryInterface
{
    public function savePostAndTranslations(PostCreateDTO $postCreateDTO, array $translations): void
    {
        $post = Post::create([
            'user_id' => auth()->id(),
            'title' => $postCreateDTO->title,
            'body' => $postCreateDTO->content,
            'is_published' => $postCreateDTO->published,
            'published_at' => $postCreateDTO->publicationDate,
            'is_featured' => $postCreateDTO->featured,
        ]);

        PostTranslation::create([
            'post_id' => $post->id,
            'locale' => $postCreateDTO->detectedLanguage,
            'title' => $postCreateDTO->title,
            'body' => $postCreateDTO->content,
        ]);

        foreach ($translations as $locale => $data) {
            // Ensure title and body are strings (convert arrays to strings if necessary)
            $title = is_array($data['title']) ? implode(' ', $data['title']) : $data['title'];
            $body = is_array($data['body']) ? implode(' ', $data['body']) : $data['body'];

            PostTranslation::create([
                'post_id' => $post->id,
                'locale' => $locale,
                'title' => $title,
                'body' => $body,
            ]);
        }

        $post->categories()->attach($postCreateDTO->selectedCategories);
    }

    // Method to delete a single post
    public function deletePostById(int $postId): void
    {
        $post = Post::findOrFail($postId);
        $post->delete();
    }

    // Method to delete multiple posts
    public function deletePostsByIds(array $postIds): void
    {
        Post::whereIn('id', $postIds)->delete();
    }
}
