<?php

namespace App\Modules\Post\Interfaces;

use App\Modules\Post\DTOs\PostDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ReadPostServiceInterface
{
    public function getPostDetails(int $postId): PostDTO;

    public function getPaginatedPosts(int $numberOfPostsPerPage, string $pageName): LengthAwarePaginator;

    public function getLatestPosts(int $numberOfPostsPerPage): Collection;

    public function getFeaturedPaginatedPosts(int $numberOfPostsPerPage, string $pageName): LengthAwarePaginator;

    public function searchPosts(string $searchTerm, bool $shouldHaveLocalization, int $perPage): ?LengthAwarePaginator;

    /* ------------------------------------------------- */
    /* Scope functions to filter a post by an attribute. */
    /* ------------------------------------------------- */

    public function getPostsByCategory(int $categoryId): Collection;

    public function getPostsByAuthor(int $authorId): mixed;

    public function getPostsByDateRange(string $startDate, string $endDate): mixed;

    public function getPostsByRelated(int $postId): mixed;
}
