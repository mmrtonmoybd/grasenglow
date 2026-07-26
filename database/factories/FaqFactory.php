<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Faq;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Faq>
 */
final class FaqFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category' => fake()->word(),
            'question' => fake()->unique()->sentence().'?',
            'answer' => fake()->paragraph(),
            'sort_order' => 10,
            'is_active' => true,
            'show_on_homepage' => false,
        ];
    }
}
