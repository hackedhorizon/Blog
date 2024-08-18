<?php

namespace Tests\Feature\Livewire\User;

use App\Livewire\User\Settings;
use Livewire\Livewire;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(Settings::class)
            ->assertStatus(200);
    }

    /** @test */
    public function contains_language_switcher_component()
    {
        config(['services.should_have_localization' => true]);
        Livewire::test(Settings::class)
            ->assertSeeLivewire('features.language-switcher');
    }
}
