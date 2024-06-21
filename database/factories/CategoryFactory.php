<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            'Laravel',
            'Cybersecurity',
            'C++',
            'C#',
            'Kernel',
            'Development',
            'Security',
            'Programming',
            'Hacking',
        ];

        return [
            'name' => $this->faker->unique()->randomElement($categories),
        ];
    }
}
