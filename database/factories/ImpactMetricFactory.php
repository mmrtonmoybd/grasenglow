<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\ImpactMetric;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ImpactMetric>
 */
final class ImpactMetricFactory extends Factory
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
            'numeric_value' => fake()->numberBetween(1, 1000),
            'display_value' => fake()->numberBetween(1, 1000).'+',
            'description' => fake()->sentence(),
            'icon' => 'heart',
            'sort_order' => 10,
            'is_active' => true,
        ];
    }
}
