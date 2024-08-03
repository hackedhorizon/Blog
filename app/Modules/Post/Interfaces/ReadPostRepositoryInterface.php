<?php

namespace App\Modules\Post\Interfaces;

use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Date;

interface ReadPostRepositoryInterface
{
    /**
     * Retrieves a post with its associated categories and author.
     *
     * @param  int  $postId  The ID of the post to retrieve.
     * @return Post A post object containing relations.
     */
    public function getPostDetails(int $postId): Post;

    /**
     * Retrieves a paginated list of posts, including their associated categories and author.
     *
     * @param  int  $numberOfPostsPerPage  The number of posts to display per page.
     * @param  string  $pageName  The name of the query parameter for the page number.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator A paginated collection of posts,
     *                                                               with each post containing its associated categories and author.
     *
     * @throws \InvalidArgumentException If the number of posts per page is less than 1.
     */
    public function getPaginatedPosts(int $numberOfPostsPerPage, string $pageName): LengthAwarePaginator;

    /**
     * Retrieves the last $numberOfPostsPerpage posts sorted by creation date in descending order.
     *
     * @param  int  $numberOfPostsPerPage  The number of posts to display on the page.
     */
    public function getLatestPosts(int $numberOfPostsPerPage): Collection;

    /**
     * Retrieves paginated featured posts.
     *
     * This function fetches a specified number of featured posts from the database,
     * organized into pages for efficient display.
     *
     * @param  int  $numberOfPostsPerPage  The number of posts to display per page.
     * @param  string  $pageName  The name of the page where the posts will be displayed.
     * @return LengthAwarePaginator A paginated collection of featured posts.
     *                              The paginator object contains the posts, as well as additional information
     *                              such as the total number of posts and the current page number.
     */
    public function getFeaturedPaginatedPosts(int $numberOfPostsPerPage, string $pageName): LengthAwarePaginator;

    /* ------------------------------------------------- */
    /* Scope functions to filter a post by an attribute. */
    /* ------------------------------------------------- */

    /**
     * Retrieves a collection of posts associated with a specific category.
     *
     * @param  int  $categoryId  The unique identifier of the category.
     * @return \Illuminate\Database\Eloquent\Collection A collection of posts associated with the given category.
     *                                                  Each post in the collection will be eager-loaded with its associated categories and author.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the category with the given ID does not exist.
     */
    public function getPostsByCategory(int $categoryId): Collection;

    /**
     * Retrieves a collection of posts associated with a specific author.
     *
     * @param  int  $authorId  The unique identifier of the author.
     * @return \Illuminate\Database\Eloquent\Collection A collection of posts associated with the given author.
     *                                                  Each post in the collection will be eager-loaded with its associated categories and author.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the author with the given ID does not exist.
     */
    public function getPostsByAuthor(int $authorId): Collection;

    /**
     * Retrieves a collection of posts created within a specific date range.
     *
     * @param  string  $startDate  The start date of the range in 'YYYY-MM-DD' format.
     * @param  string  $endDate  The end date of the range in 'YYYY-MM-DD' format.
     * @return \Illuminate\Database\Eloquent\Collection A collection of posts created within the given date range.
     *                                                  Each post in the collection will be eager-loaded with its associated categories and author.
     *
     * @throws \InvalidArgumentException If the start date is after the end date.
     */
    public function getPostsByDateRange(string $startDate, string $endDate): Collection;

    /**
     * Retrieves a collection of related posts based on the given post's categories and author.
     *
     * @param  int  $postId  The unique identifier of the post.
     * @return \Illuminate\Database\Eloquent\Collection A collection of related posts.
     *                                                  Each post in the collection will be eager-loaded with its associated categories and author.
     *                                                  The related posts are determined based on the categories and author of the given post.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the post with the given ID does not exist.
     */
    public function getRelatedPosts(int $postId): Collection;
}
