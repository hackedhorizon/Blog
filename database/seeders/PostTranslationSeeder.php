<?php

namespace Database\Seeders;

use App\Models\PostTranslation;
use Illuminate\Database\Seeder;

class PostTranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 100 dummy post translations if localization service is enabled.
        if (config('services.should_have_localization')) {
            PostTranslation::factory(100)->create();
        }
    }
}
