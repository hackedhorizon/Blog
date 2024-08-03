<?php

namespace App\Modules\Post\Repositories;

use App\Models\Category;
use App\Models\Post;
use App\Modules\Post\Interfaces\ReadPostRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ReadPostRepository implements ReadPostRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getPostDetails(int $postId): Post
    {
        return Post::with('user', 'categories')->findOrFail($postId);
    }

    /**
     * {@inheritdoc}
     */
    public function getPaginatedPosts(int $numberOfPostsPerPage, string $pageName): LengthAwarePaginator
    {
        return Post::with(['categories', 'user'])->where('is_published', true)->paginate($numberOfPostsPerPage, pageName: $pageName);
    }

    /**
     * {@inheritdoc}
     */
    public function getLatestPosts(int $numberOfPostsPerPage): Collection
    {
        return Post::with(['categories', 'user'])->where('is_published', true)->latest()->take($numberOfPostsPerPage)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getFeaturedPaginatedPosts(int $numberOfPostsPerPage, string $pageName): LengthAwarePaginator
    {
        return Post::with(['categories', 'user'])->where('is_featured', true)->where('is_published', true)->paginate($numberOfPostsPerPage, pageName: $pageName);
    }

    /* ------------------------------------------------- */
    /* Scope functions to filter a post by an attribute. */
    /* ------------------------------------------------- */

    /**
     * {@inheritdoc}
     */
    public function getPostsByCategory(int $categoryId): Collection
    {
        $category = Category::find($categoryId);

        if ($category) {
            return $category->posts()->with(['categories', 'user'])->get();
        }

        return collect();
    }

    /**
     * {@inheritdoc}
     */
    public function getPostsByAuthor(int $authorId): Collection
    {
        return Post::byAuthor($authorId)->with(['categories', 'user'])->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getPostsByDateRange(string $startDate, string $endDate): Collection
    {
        return Post::byDateRange($startDate, $endDate)->with(['categories', 'user'])->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getRelatedPosts(int $postId): Collection
    {
        return Post::byRelated($postId)->with(['categories', 'user'])->get();
    }
}
