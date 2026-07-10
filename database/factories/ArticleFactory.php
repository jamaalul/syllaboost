<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'slug' => fake()->unique()->slug(),
            'content' => fake()->paragraphs(5, true),
            'image_path' => 'https://dummyimage.com/600x400/000/fff',
            'is_published' => true,
            'published_at' => fake()->dateTimeBetween('-6 months', 'now'),
        ];
    }
}
