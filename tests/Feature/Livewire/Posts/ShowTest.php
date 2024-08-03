<?php

namespace Tests\Feature\Livewire\Posts;

use App\Livewire\Posts\Show;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        User::factory()->count(1)->create();
        $post = Post::factory()->count(1)->create(['is_published' => true])->first();

        Livewire::test(Show::class, ['id' => $post->id])
            ->assertStatus(200);
    }
}
