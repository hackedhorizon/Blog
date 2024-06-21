<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Seeder;

class CategoryPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 20 dummy posts
        $posts = Post::factory(20)->create();

        // Create 5 dummy categories
        $categories = Category::factory(5)->create();

        // Add a category for each post in the database
        foreach ($posts as $post) {
            $post->categories()->sync($categories->random(3)->pluck('id')->toArray());
        }
    }
}
