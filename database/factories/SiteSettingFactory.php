<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\SiteSetting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SiteSetting>
 */
final class SiteSettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'singleton_key' => 'default',
            'site_name' => 'Grace & Glow',
            'primary_tagline' => 'Transforming Textile Waste into Hope',
            'primary_color' => '#24462d',
            'secondary_color' => '#17381f',
            'accent_color' => '#d98a75',
            'background_color' => '#f5f0e7',
            'text_color' => '#1e271f',
            'heading_font' => 'Playfair Display',
            'body_font' => 'DM Sans',
            'default_meta_title' => 'Grace & Glow',
            'default_meta_description' => fake()->sentence(),
            'robots_index_enabled' => true,
            'sitemap_enabled' => true,
        ];
    }
}
