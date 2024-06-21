<?php

namespace Tests\Feature\Livewire\Posts;

use App\Livewire\Posts\Post;
use Livewire\Livewire;
use Tests\TestCase;

class PostTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(Post::class)
            ->assertStatus(200);
    }
}
