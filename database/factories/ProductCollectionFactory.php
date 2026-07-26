<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\ContentStatus;
use App\Models\ProductCollection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductCollection>
 */
final class ProductCollectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(2, true),
            'slug' => fake()->unique()->slug(),
            'short_description' => fake()->sentence(),
            'status' => ContentStatus::Published,
            'published_at' => now()->subDay(),
            'is_featured' => false,
        ];
    }
}
