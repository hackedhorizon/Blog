<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = User::pluck('id');

        return [
            'user_id' => fake()->randomElement($users),
            'title' => fake()->sentence(),
            'body' => fake()->paragraph(),
            'is_published' => fake()->randomElement([false, true]),
            'is_featured' => fake()->randomElement([false, true]),
            'published_at' => fake()->dateTimeThisMonth()
        ];
    }
}
