<?php

namespace App\Modules\Post\Interfaces;

use App\Modules\Post\DTOs\PostDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ReadPostServiceInterface
{
    /**
     * Retrieves the details of a specific post.
     *
     * @param  int  $postId  The ID of the post to retrieve.
     * @return PostDTO A data transfer object containing post details.
     */
    public function getPostDetails(int $postId): PostDTO;

    /**
     * Retrieves a paginated list of posts.
     *
     * @param  array  $sortBy  Sorting parameters (column and direction).
     * @param  string  $search  The search term for filtering posts.
     * @param  int  $perPage  The number of posts to display per page.
     * @return LengthAwarePaginator A paginated collection of posts.
     */
    public function getPaginatedPosts(array $sortBy, string $search, int $perPage): LengthAwarePaginator;

    /**
     * Retrieves the latest posts.
     *
     * @param  int  $numberOfPostsPerPage  The number of posts to display on the page.
     * @return Collection A collection of the latest posts.
     */
    public function getLatestPosts(int $numberOfPostsPerPage): Collection;

    /**
     * Retrieves paginated featured posts.
     *
     * @param  int  $numberOfPostsPerPage  The number of posts to display per page.
     * @param  string  $pageName  The name of the page where the posts will be displayed.
     * @return LengthAwarePaginator A paginated collection of featured posts.
     */
    public function getFeaturedPaginatedPosts(int $numberOfPostsPerPage, string $pageName): LengthAwarePaginator;

    /**
     * Searches for posts based on a term and localization.
     *
     * @param  string  $searchTerm  The term to search for in the posts.
     * @param  bool  $shouldHaveLocalization  Indicates whether the posts should have localization.
     * @param  int  $perPage  The number of posts to return per page.
     * @return LengthAwarePaginator|null A collection of posts that match the search criteria.
     */
    public function searchPosts(string $searchTerm, bool $shouldHaveLocalization, int $perPage): ?LengthAwarePaginator;

    /* ------------------------------------------------- */
    /* Scope functions to filter a post by an attribute. */
    /* ------------------------------------------------- */

    /**
     * Retrieves a collection of posts associated with a specific category.
     *
     * @param  int  $categoryId  The unique identifier of the category.
     * @return Collection A collection of posts associated with the given category.
     */
    public function getPostsByCategory(int $categoryId): Collection;

    /**
     * Retrieves a collection of posts associated with a specific author.
     *
     * @param  int  $authorId  The unique identifier of the author.
     * @return Collection A collection of posts associated with the given author.
     */
    public function getPostsByAuthor(int $authorId): Collection;

    /**
     * Retrieves a collection of posts created within a specific date range.
     *
     * @param  string  $startDate  The start date of the range in 'YYYY-MM-DD' format.
     * @param  string  $endDate  The end date of the range in 'YYYY-MM-DD' format.
     * @return Collection A collection of posts created within the given date range.
     */
    public function getPostsByDateRange(string $startDate, string $endDate): Collection;

    /**
     * Retrieves a collection of related posts based on the given post's categories and author.
     *
     * @param  int  $postId  The unique identifier of the post.
     * @return Collection A collection of related posts.
     */
    public function getPostsByRelated(int $postId): Collection;
}
