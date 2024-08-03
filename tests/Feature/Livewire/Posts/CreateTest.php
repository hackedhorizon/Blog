<?php

namespace Tests\Feature\Livewire\Posts;

use App\Livewire\Posts\Create;
use Livewire\Livewire;
use Tests\TestCase;

class CreateTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(Create::class)
            ->assertStatus(200);
    }
}
