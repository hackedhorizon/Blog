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
        // Default factory definition can remain empty or generic if needed
        return [];
    }

    /**
     * English translation state.
     */
    public function english(): Factory
    {
        $faker_en = Faker::create('en_EN');

        $posts = Post::pluck('id');

        return $this->state(fn () => [
            'post_id' => fake()->randomElement($posts),
            'title' => $faker_en->realText(),
            'body' => $faker_en->realText(),
            'locale' => 'en',
        ]);
    }

    /**
     * Hungarian translation state.
     */
    public function hungarian(): Factory
    {
        $faker_hu = Faker::create('hu_HU');

        $posts = Post::pluck('id');

        return $this->state(fn () => [
            'post_id' => fake()->randomElement($posts),
            'title' => $faker_hu->realText(),
            'body' => $faker_hu->realText(),
            'locale' => 'hu',
        ]);
    }
}
