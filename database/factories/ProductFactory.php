<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\ContentStatus;
use App\Enums\ProductAvailabilityStatus;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
final class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_category_id' => ProductCategory::factory(),
            'name' => fake()->unique()->words(3, true),
            'slug' => fake()->unique()->slug(),
            'short_description' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'availability_status' => ProductAvailabilityStatus::InquiryOnly,
            'inquiry_enabled' => true,
            'status' => ContentStatus::Published,
            'published_at' => now()->subDay(),
            'is_featured' => false,
            'is_new' => false,
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
}
