<?php

namespace App\Modules\Post\Repositories;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostTranslation;
use App\Modules\Post\Interfaces\ReadPostRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

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
    public function getPaginatedPosts(array $sortBy, string $search, int $perPage): LengthAwarePaginator
    {
        // Base query for posts with user aggregate
        $query = Post::query()
            ->withAggregate('user', 'username')
            ->orderBy($sortBy['column'], $sortBy['direction']);

        // Check if localization is enabled
        if (config('services.should_have_localization') && $search) {
            // If there's a search term, search via Algolia on the PostTranslation table
            $postIds = PostTranslation::search($search)
                ->get()
                ->pluck('post_id');

            // Apply filtering by the found post IDs
            $query->whereIn('id', $postIds);
        }

        // Return the paginated result
        return $query->paginate($perPage);
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

    /**
     * {@inheritdoc}
     */
    public function searchPosts(string $searchTerm, bool $shouldHaveLocalization, int $perPage): ?LengthAwarePaginator
    {
        if ($searchTerm) {
            if ($shouldHaveLocalization) {
                return $this->getLocalizedPosts($searchTerm, $perPage);
            } else {
                return $this->getNonLocalizedPosts($searchTerm, $perPage);
            }
        }

        return $this->getAllPosts($perPage);
    }

    protected function getLocalizedPosts(string $search, int $perPage)
    {
        $translations = PostTranslation::search($search)->get();
        $postIds = $translations->pluck('post_id');

        if ($postIds->isEmpty()) {
            return Post::whereNull('id')->paginate($perPage, ['*'], 'article-page');
        }

        return Post::with(['user', 'categories'])
            ->where('is_published', true)
            ->whereIn('id', $postIds)
            ->paginate($perPage, ['*'], 'article-page');
    }

    protected function getNonLocalizedPosts(string $search, int $perPage)
    {
        $currentPage = LengthAwarePaginator::resolveCurrentPage('article-page');
        $posts = Post::search($search)->get()->filter(fn ($post) => $post->is_published);

        $paginatedPosts = new LengthAwarePaginator(
            $posts->forPage($currentPage, $perPage),
            $posts->count(),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath(), 'pageName' => 'article-page']
        );

        $paginatedPosts->load(['user', 'categories']);

        return $paginatedPosts;
    }

    protected function getAllPosts(int $perPage)
    {
        return Post::with(['categories', 'user'])
            ->where('is_published', true)
            ->paginate($perPage, ['*'], 'article-page');
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
