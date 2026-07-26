<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\SectionType;
use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PageSection>
 */
final class PageSectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'page_id' => Page::factory(),
            'section_type' => SectionType::RichText,
            'internal_name' => fake()->unique()->words(3, true),
            'heading' => fake()->sentence(4),
            'body' => fake()->paragraph(),
            'sort_order' => 10,
            'is_enabled' => true,
        ];
    }
}
