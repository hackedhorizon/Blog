<?php

namespace Tests\Feature\Livewire\Posts;

use App\Livewire\Posts\Featured;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class FeaturedTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(Featured::class)
            ->assertStatus(200);
    }
}
