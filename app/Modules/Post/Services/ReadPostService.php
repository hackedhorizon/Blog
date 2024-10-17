<?php

namespace App\Modules\Post\Services;

use App\Models\Post;
use App\Modules\Post\DTOs\PostDTO;
use App\Modules\Post\Interfaces\ReadPostServiceInterface;
use App\Modules\Post\Repositories\ReadPostRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ReadPostService implements ReadPostServiceInterface
{
    protected ReadPostRepository $readPostRepository;

    public function __construct(ReadPostRepository $readPostRepository)
    {
        $this->readPostRepository = $readPostRepository;
    }

    public function getPostDetails(int $postId): PostDTO
    {
        $post = $this->readPostRepository->getPostDetails($postId);

        return new PostDTO($post);
    }

    public function getPaginatedPosts(array $sortBy, string $search, int $perPage): LengthAwarePaginator
    {
        return $this->readPostRepository->getPaginatedPosts($sortBy, $search, $perPage);
    }

    public function getLatestPosts(int $numberOfPostsPerPage): Collection
    {
        return $this->readPostRepository->getLatestPosts($numberOfPostsPerPage);
    }

    public function getFeaturedPaginatedPosts(int $numberOfPostsPerPage, string $pageName): LengthAwarePaginator
    {
        return $this->readPostRepository->getFeaturedPaginatedPosts($numberOfPostsPerPage, $pageName);
    }

    public function searchPosts(string $searchTerm, bool $shouldHaveLocalization, int $perPage): ?LengthAwarePaginator
    {
        return $this->readPostRepository->searchPosts($searchTerm, $shouldHaveLocalization, $perPage);
    }

    /* ------------------------------------------------- */
    /* Scope functions to filter a post by an attribute. */
    /* ------------------------------------------------- */

    public function getPostsByCategory(int $categoryId): Collection
    {
        return $this->readPostRepository->getPostsByCategory($categoryId);
    }

    public function getPostsByAuthor(int $authorId): Collection
    {
        return $this->readPostRepository->getPostsByAuthor($authorId);
    }

    public function getPostsByDateRange(string $startDate, string $endDate): Collection
    {
        return $this->readPostRepository->getPostsByDateRange($startDate, $endDate);
    }

    public function getPostsByRelated(int $postId): Collection
    {
        return $this->readPostRepository->getRelatedPosts($postId);
    }
}
