<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\BrandValue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BrandValue>
 */
final class BrandValueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->unique()->word(),
            'description' => fake()->sentence(),
            'icon' => 'leaf',
            'sort_order' => 10,
            'is_active' => true,
        ];
    }
}
