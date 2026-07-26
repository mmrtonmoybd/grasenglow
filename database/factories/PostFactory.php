<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\ContentStatus;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
final class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'post_category_id' => PostCategory::factory(),
            'title' => fake()->unique()->sentence(5),
            'slug' => fake()->unique()->slug(),
            'excerpt' => fake()->sentence(),
            'body' => fake()->paragraphs(3, true),
            'status' => ContentStatus::Published,
            'published_at' => now()->subDay(),
            'is_featured' => false,
            'is_indexable' => true,
        ];
    }

    public function draft(): static
    {
        return $this->state(fn (): array => ['status' => ContentStatus::Draft, 'published_at' => null]);
    }
}
