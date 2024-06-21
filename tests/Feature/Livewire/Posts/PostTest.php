<?php

namespace Tests\Feature\Livewire\Posts;

use App\Livewire\Posts\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
