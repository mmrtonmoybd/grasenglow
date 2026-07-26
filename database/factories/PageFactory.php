<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\ContentStatus;
use App\Enums\PageTemplate;
use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Page>
 */
final class PageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->unique()->sentence(3),
            'slug' => fake()->unique()->slug(),
            'page_template' => PageTemplate::Standard,
            'excerpt' => fake()->sentence(),
            'body' => fake()->paragraphs(2, true),
            'status' => ContentStatus::Published,
            'published_at' => now()->subDay(),
            'is_indexable' => true,
        ];
    }

    public function draft(): static
    {
        return $this->state(fn (): array => ['status' => ContentStatus::Draft, 'published_at' => null]);
    }

    public function scheduled(): static
    {
        return $this->state(fn (): array => ['status' => ContentStatus::Scheduled, 'published_at' => now()->addDay()]);
    }

    public function archived(): static
    {
        return $this->state(fn (): array => ['status' => ContentStatus::Archived]);
    }
}
