<?php

namespace Tests\Feature\Livewire\AdminPanel\Posts;

use App\Livewire\AdminPanel\Posts\Index;
use App\Models\Post;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Disable lazy loading for more predictable tests
        Livewire::withoutLazyLoading();

        // Seed roles and permissions
        $this->seed([RoleSeeder::class, PermissionSeeder::class]);

        // Create an admin user for testing
        $this->user = User::factory()->create([
            'password' => bcrypt('password'), // Default password
        ])->assignRole('admin');
    }

    /**
     * Test that the Index component renders successfully.
     */
    public function test_it_renders_successfully()
    {
        Livewire::actingAs($this->user)
            ->test(Index::class)
            ->assertStatus(200);
    }

    /**
     * Test that paginated posts are shown correctly.
     */
    public function test_it_shows_paginated_posts()
    {
        $posts = Post::factory()->count(11)->create(['user_id' => $this->user->id]);
        $lastPostTitle = $posts->last()->title;

        Livewire::actingAs($this->user)
            ->test(Index::class)
            ->assertSee($lastPostTitle)
            ->assertStatus(200);
    }

    /**
     * Test that paginated posts are shown when localization is disabled.
     */
    public function test_it_shows_paginated_posts_localization_disabled()
    {
        config(['services.should_have_localization' => false]);

        $posts = Post::factory()->count(10)->create(['user_id' => $this->user->id]);
        $lastPostTitle = $posts->last()->title;

        Livewire::actingAs($this->user)
            ->test(Index::class)
            ->assertSee($lastPostTitle)
            ->assertStatus(200);
    }

    /**
     * Test that a single post can be deleted.
     */
    public function test_it_deletes_a_single_post()
    {
        $post = Post::factory()->create(['user_id' => $this->user->id]);

        Livewire::actingAs($this->user)
            ->test(Index::class)
            ->call('delete', postId: $post->id)
            ->assertDontSee($post->title)
            ->assertDontSee($post->translated_title);
    }

    /**
     * Test that multiple selected posts can be deleted.
     */
    public function test_it_deletes_multiple_selected_posts()
    {
        $posts = Post::factory()->count(5)->create(['user_id' => $this->user->id]);
        $selectedPosts = $posts->pluck('id')->toArray();

        Livewire::actingAs($this->user)
            ->test(Index::class)
            ->set('selected', $selectedPosts)
            ->assertSet('selected', $selectedPosts)
            ->call('delete', postId: null)
            ->assertDontSee($posts[0]->title);
    }

    /**
     * Test pagination of posts based on selected perPage value.
     */
    public function test_it_can_paginate_posts_per_page()
    {
        Post::factory()->count(15)->create(['user_id' => $this->user->id]);

        Livewire::actingAs($this->user)
            ->test(Index::class)
            ->set('perPage', 10)
            ->assertCount('posts', 10)
            ->set('perPage', 20)
            ->assertCount('posts', 15);
    }

    /**
     * Test sorting posts by created_at in descending order.
     */
    public function test_it_can_sort_posts_by_created_at_desc()
    {
        Post::factory()->count(5)->create(['user_id' => $this->user->id]);

        Livewire::actingAs($this->user)
            ->test(Index::class)
            ->set('perPage', 20)
            ->set('sortBy', ['column' => 'created_at', 'direction' => 'desc'])
            ->assertSeeInOrder(Post::latest()->pluck('title')->toArray());
    }

    /**
     * Test sorting posts by created_at in ascending order.
     */
    public function test_it_can_sort_posts_by_created_at_asc()
    {
        Post::factory()->count(5)->create(['user_id' => $this->user->id]);

        Livewire::actingAs($this->user)
            ->test(Index::class)
            ->set('perPage', 20)
            ->set('sortBy', ['column' => 'created_at', 'direction' => 'asc'])
            ->assertSeeInOrder(Post::oldest()->pluck('title')->toArray());
    }

    /**
     * Test that selected posts are updated correctly.
     */
    public function test_it_updates_selected_posts_correctly()
    {
        $posts = Post::factory()->count(3)->create(['user_id' => $this->user->id]);
        $selectedPostIds = $posts->pluck('id')->toArray();

        Livewire::actingAs($this->user)
            ->test(Index::class)
            ->call('updateSelected', $selectedPostIds)
            ->assertSet('selected', $selectedPostIds);
    }

    /**
     * Test that the component initializes with default values.
     */
    public function test_it_initializes_with_default_values()
    {
        Livewire::actingAs($this->user)
            ->test(Index::class)
            ->assertSet('search', '')
            ->assertSet('perPage', 10)
            ->assertSet('sortBy', ['column' => 'created_at', 'direction' => 'desc']);
    }

    /**
     * Test that a placeholder is displayed when no posts are available.
     */
    public function test_it_can_display_placeholder_when_no_posts_are_available()
    {
        Post::query()->delete(); // Delete all posts to trigger the empty state

        Livewire::actingAs($this->user)
            ->test(Index::class)
            ->assertSee(__('posts.empty')); // Ensure the correct placeholder message is shown
    }
}
