<?php

namespace Tests\Feature\Livewire\Auth;

use App\Livewire\Auth\Permissions;
use Livewire\Livewire;
use Tests\TestCase;

class PermissionsTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(Permissions::class)
            ->assertStatus(200);
    }
}
