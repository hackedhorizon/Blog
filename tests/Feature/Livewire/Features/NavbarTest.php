<?php

namespace Tests\Feature\Livewire\Features;

use App\Livewire\Features\Navbar;
use Livewire\Livewire;
use Tests\TestCase;

class NavbarTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(Navbar::class)
            ->assertStatus(200);
    }
}
