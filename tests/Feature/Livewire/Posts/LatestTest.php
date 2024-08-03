<?php

namespace Tests\Feature\Livewire\Posts;

use App\Livewire\Posts\Latest;
use App\Models\Post;
use App\Models\PostTranslation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LatestTest extends TestCase
{
    use RefreshDatabase;

    /**
     * This test method verifies that the Latest Livewire component renders successfully.
     *
     * @test
     *
     * @return void
     */
    public function renders_successfully()
    {
        // Use Livewire's test method to instantiate the Latest component and assert its HTTP status code
        Livewire::test(Latest::class)
            ->assertStatus(200);
    }

    /**
     * This test method verifies that the Latest Livewire component displays the latest posts.
     *
     * @test
     *
     * @return void
     */
    public function it_displays_latest_posts()
    {
        // Create 3 users using Laravel's User factory
        $users = User::factory()->count(3)->create();

        // Create 3 posts using Laravel's Post factory
        $posts = Post::factory()->count(3)->create([
            'is_published' => true,
        ]);

        $post_translations = PostTranslation::factory()->count(50)->create();

        // Instantiate the Latest Livewire component and assert that it displays the titles of the first and last posts
        Livewire::test(Latest::class)
            ->assertSee($posts->first()->translated_title)
            ->assertSee($posts->last()->translated_title);
    }
}
