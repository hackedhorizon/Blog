<?php

namespace Tests\Feature\Livewire\Posts;

use App\Livewire\Posts\Index;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Livewire::withoutLazyLoading();
    }

    public function test_it_renders_the_component_successfully()
    {
        $users = User::factory()->count(6)->create();
        $posts = Post::factory()->count(6)->create(['is_featured' => true, 'is_published' => true]);
        $firstPostTitle = $posts->first()->title;

        Livewire::test(Index::class)
            ->assertStatus(200)
            ->assertSee($firstPostTitle);
    }

    public function test_it_shows_posts_on_initial_render()
    {
        $users = User::factory()->count(6)->create();
        $posts = Post::factory()->count(6)->create(['is_featured' => true, 'is_published' => true]);
        $firstPostTitle = $posts->first()->title;

        Livewire::test(Index::class)
            ->assertSee($firstPostTitle);
    }

    public function test_it_paginates_the_posts_correctly()
    {
        $users = User::factory()->count(6)->create();
        $posts = Post::factory()->count(30)->create(['is_featured' => true, 'is_published' => true]);

        Livewire::test(Index::class)
            ->call('nextPage', 'article-page')
            ->assertStatus(200);
    }

    public function test_it_resets_the_page_when_search_term_is_updated()
    {
        $users = User::factory()->count(6)->create();
        $posts = Post::factory()->count(6)->create(['is_featured' => true, 'is_published' => true]);
        $firstPostTitle = $posts->first()->title;

        Livewire::test(Index::class)
            ->set('search', 'search term')
            ->call('nextPage', 'article-page')
            ->set('search', '')
            ->assertSee($firstPostTitle);
    }

    public function test_it_uses_the_read_post_service_to_fetch_posts()
    {
        $users = User::factory()->count(6)->create();
        $posts = Post::factory()->count(30)->create(['is_featured' => true, 'is_published' => true]);
        $firstPostTitle = $posts->first()->title;

        Livewire::test(Index::class)
            ->assertSee($firstPostTitle);
    }

    public function test_it_renders_the_correct_pagination_view()
    {
        $user = User::factory()->create();
        Post::factory()->count(15)->create([
            'user_id' => $user->id,
        ]);

        Livewire::test(Index::class)
            ->assertStatus(200);
    }
}
