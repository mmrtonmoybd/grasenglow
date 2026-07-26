<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\ContentStatus;
use App\Enums\ResearchStatus;
use App\Models\ResearchPublication;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ResearchPublication>
 */
final class ResearchPublicationFactory extends Factory
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
            'abstract' => fake()->paragraph(),
            'research_status' => ResearchStatus::Ongoing,
            'publication_status' => ContentStatus::Published,
            'published_at' => now()->subDay(),
        ];
    }
}
