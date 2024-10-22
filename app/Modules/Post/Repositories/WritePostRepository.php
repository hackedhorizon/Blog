<?php

namespace App\Modules\Post\Repositories;

use App\Models\Post;
use App\Models\PostTranslation;
use App\Modules\Post\DTOs\PostCreateDTO;
use App\Modules\Post\Interfaces\WritePostRepositoryInterface;

class WritePostRepository implements WritePostRepositoryInterface
{
    public function savePost(PostCreateDTO $postCreateDTO)
    {
        // Create the main post
        $post = Post::create([
            'user_id' => auth()->id(),
            'title' => $postCreateDTO->title,
            'body' => $postCreateDTO->content,
            'is_published' => $postCreateDTO->published,
            'published_at' => $postCreateDTO->publicationDate,
            'is_featured' => $postCreateDTO->featured,
        ]);

        $this->attachCategories($post, $postCreateDTO->selectedCategories);
    }

    public function savePostAndTranslations(PostCreateDTO $postCreateDTO, array $translations): void
    {
        // Create the main post
        $post = Post::create([
            'user_id' => auth()->id(),
            'title' => $postCreateDTO->title,
            'body' => $postCreateDTO->content,
            'is_published' => $postCreateDTO->published,
            'published_at' => $postCreateDTO->publicationDate,
            'is_featured' => $postCreateDTO->featured,
        ]);

        // Save the main post translation (detected language)
        $this->saveTranslation($post->id, $postCreateDTO->detectedLanguage, $postCreateDTO->title, $postCreateDTO->content);

        // Iterate through the translations for each locale
        foreach ($translations as $locale => $data) {
            $this->saveTranslation($post->id, $locale, $data['title'], $data['body']);
        }

        // Attach selected categories to the post
        $this->attachCategories($post, $postCreateDTO->selectedCategories);
    }

    // Method to save translations
    private function saveTranslation(int $postId, string $locale, string $title, string $body): void
    {
        PostTranslation::updateOrCreate(
            ['post_id' => $postId, 'locale' => $locale],
            ['title' => (string) $title, 'body' => (string) $body]
        );
    }

    // Method to attach categories to a post
    private function attachCategories(Post $post, array $selectedCategories): void
    {
        if (! empty($selectedCategories)) {
            $post->categories()->attach($selectedCategories);
        }
    }

    public function updatePost(int $postId, array $data, array $categories, ?array $translations = null): void
    {
        // Update the main post
        $post = Post::findOrFail($postId);

        // Update existing translation
        if (config('services.should_have_localization')) {
            $this->saveTranslation($postId, $data['detectedLanguage'], $data['title'], $data['body']);
        }

        // Remove the 'detectedLanguage' from the data array since it's not a field
        // in the model. It's only used for updating the original translation. This is
        // necessary because we can't translate from a language into itself. However,
        // if the post is modified, we still need to update the original translation.
        // The detected source language is temporarily stored here to facilitate
        // updating the existing translation before removing it from the data.
        unset($data['detectedLanguage']);

        // Update the post's other attributes
        $post->update($data);

        // Update translations if any
        if (! empty($translations)) {
            foreach ($translations as $locale => $content) {
                $this->saveTranslation($postId, $locale, $content['title'], $content['body']);
            }
        }

        // Update attached categories
        $post->categories()->sync($categories);
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
