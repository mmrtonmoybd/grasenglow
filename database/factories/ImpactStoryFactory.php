<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\ContentStatus;
use App\Models\ImpactStory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ImpactStory>
 */
final class ImpactStoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->unique()->sentence(4),
            'slug' => fake()->unique()->slug(),
            'excerpt' => fake()->sentence(),
            'body' => fake()->paragraph(),
            'status' => ContentStatus::Published,
            'published_at' => now()->subDay(),
            'is_featured' => false,
        ];
    }
}
