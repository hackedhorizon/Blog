<?php

namespace Tests\Feature\Livewire\Posts;

use App\Livewire\Posts\Featured;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class FeaturedTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests if the Featured Livewire component renders successfully.
     *
     * This test verifies that the Featured Livewire component is able to render without any errors.
     * It uses Laravel's Livewire testing framework to create an instance of the Featured component
     * and asserts that the HTTP response status code is 200, indicating a successful render.
     *
     * @test
     *
     * @return void
     */
    public function renders_successfully()
    {
        Livewire::test(Featured::class)
            ->assertStatus(200);
    }

    /**
     * Tests if the Featured component exists on the home page.
     *
     * This test verifies that the Featured component is rendered on the home page.
     * It uses Laravel's testing framework to send a GET request to the home page route
     * and asserts that the response contains the Livewire component.
     *
     * @test
     *
     * @return void
     */
    public function component_exists_on_the_page()
    {
        $this->get(route('home'))
            ->assertSeeLivewire(Featured::class);
    }

    /**
     * Tests the pagination functionality of featured posts.
     *
     * This test creates multiple users and posts, then verifies that the pagination
     * works correctly by checking the visibility of the first and last post titles
     * on different pages.
     *
     * @test
     *
     * @return void
     */
    public function it_can_paginate_featured_posts()
    {
        // Create users and posts
        $users = User::factory()->count(6)->create();
        $posts = Post::factory()->count(6)->create(['is_featured' => true, 'is_published' => true]);

        // Get the first and last post titles
        $firstPostTitle = $posts->first()->title;
        $lastPostTitle = $posts->last()->title;

        // Start Livewire test
        Livewire::test(Featured::class)
            ->assertSee($firstPostTitle) // Check first post title is visible
            ->call('nextPage', 'featured-post') // Move to next page
            ->assertSee($lastPostTitle); // Check last post title is visible
    }
}
