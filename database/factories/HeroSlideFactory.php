<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\HeroSlide;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<HeroSlide>
 */
final class HeroSlideFactory extends Factory
{
    protected $model = HeroSlide::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'internal_name' => fake()->unique()->words(3, true),
            'eyebrow' => 'Sustainable craftsmanship',
            'heading' => fake()->sentence(4),
            'subheading' => fake()->sentence(3),
            'body' => fake()->paragraph(),
            'feature_items' => [
                [
                    'icon' => 'recycle',
                    'tone' => 'forest',
                    'title' => 'We collect textile waste',
                    'body' => 'We collect textile waste from local sources.',
                ],
                [
                    'icon' => 'scissors',
                    'tone' => 'rose',
                    'title' => 'We upcycle it into quilts, bags & more.',
                    'body' => 'We upcycle it into quilts, bags, and practical handmade pieces.',
                ],
                [
                    'icon' => 'paw',
                    'tone' => 'gold',
                    'title' => 'We support stray animals',
                    'body' => 'We support stray animals through food and medical care.',
                ],
            ],
            'closing_text' => 'Every fabric saved protects our planet. Every creation made brings hope.',
            'image' => 'grace-glow/hero-showcase-left-crop.png',
            'mobile_image' => 'grace-glow/hero-showcase-left-crop.png',
            'image_alt' => fake()->sentence(6),
            'primary_cta_label' => 'Explore',
            'primary_cta_url' => '/products',
            'secondary_cta_label' => 'Learn more',
            'secondary_cta_url' => '/about',
            'duration_seconds' => 3,
            'sort_order' => fake()->numberBetween(1, 100),
            'is_enabled' => true,
            'source_url' => 'https://commons.wikimedia.org/',
            'license' => 'CC BY-SA 4.0',
            'attribution' => 'Wikimedia Commons contributor',
        ];
    }
}
