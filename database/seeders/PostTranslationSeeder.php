<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostTranslation;
use Illuminate\Database\Seeder;

class PostTranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if localization service is enabled
        if (config('services.should_have_localization')) {
            // Fetch all posts
            $posts = Post::all();

            // Loop through each post and create translations for 'en' and 'hu'
            foreach ($posts as $post) {
                // Create one translation for English
                PostTranslation::factory()
                    ->for($post)  // Associate with the post
                    ->english()   // Use the English state
                    ->create();

                // Create one translation for Hungarian
                PostTranslation::factory()
                    ->for($post)  // Associate with the post
                    ->hungarian() // Use the Hungarian state
                    ->create();
            }
        }
    }
}
