<?php

namespace Tests\Feature\Livewire\AdminPanel\Posts;

use App\Livewire\AdminPanel\Posts\Edit;
use App\Models\Post;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class EditTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        // Seed roles and permissions
        $this->seed([RoleSeeder::class, PermissionSeeder::class]);

        // Create an admin user for testing
        $user = User::factory()->create([
            'password' => bcrypt('password'), // Default password
        ])->assignRole('admin');

        $post = Post::factory()->create(['user_id' => $user->id]);

        Livewire::actingAs($user)
            ->test(Edit::class, ['post' => $post->id])
            ->assertSet('title', $post->title)
            ->assertSet('body', $post->body)
            ->assertSet('author', $user->name)
            ->assertSet('featured', $post->is_featured)
            ->assertSet('title', $post->title)
            ->assertSet('body', $post->body)
            ->assertStatus(200);
    }

    /** @test */
    public function non_admin_cannot_access_the_edit_page()
    {
        // Create a regular user
        $user = User::factory()->create([
            'password' => bcrypt('password'), // Default password
        ]);

        $post = Post::factory()->create();

        Livewire::actingAs($user)
            ->test(Edit::class, ['post' => $post->id])
            ->assertForbidden(); // Ensure non-admins cannot access
    }

    /** @test */
    public function post_can_be_updated_successfully()
    {
        // Seed roles and permissions
        $this->seed([RoleSeeder::class, PermissionSeeder::class]);

        // Create an admin user
        $user = User::factory()->create()->assignRole('admin');

        // Create a post
        $post = Post::factory()->create(['user_id' => $user->id]);

        // New post data
        $newData = [
            'title' => 'Updated Title',
            'body' => 'Updated body content.',
            'featured' => 1,
        ];

        // Act as the admin user, update post data, and submit the form
        Livewire::actingAs($user)
            ->test(Edit::class, ['post' => $post->id])
            ->set('title', $newData['title'])
            ->set('body', $newData['body'])
            ->set('featured', $newData['featured'])
            ->call('save')
            ->assertDispatched('post-updated')
            ->assertHasNoErrors();
    }
}
