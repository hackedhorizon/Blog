<?php

namespace Database\Factories;

use App\Models\Post;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PostTranslation>
 */
class PostTranslationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $languageCodes = array_keys(config('app.locales'));    // Fetch language codes from config
        $languageCode = $languageCodes[array_rand($languageCodes)]; // Choose random language code
        $posts = Post::pluck('id');                                        // Get all posts id's.

        $faker_en = Faker::create('en_EN');
        $faker_hu = Faker::create('hu_HU');

        if ($languageCode === 'en') {
            return [
                'post_id' => fake()->randomElement($posts),
                'locale' => $languageCode,
                'title' => $faker_en->realText(),
                'body' => $faker_en->realText(),
            ];
        }

        return [
            'post_id' => fake()->randomElement($posts),
            'locale' => $languageCode,
            'title' => $faker_hu->realText(),
            'body' => $faker_hu->realText(),
        ];
    }
}
