<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\LinkType;
use App\Models\NavigationItem;
use App\Models\NavigationMenu;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<NavigationItem>
 */
final class NavigationItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'navigation_menu_id' => NavigationMenu::factory(),
            'label' => fake()->words(2, true),
            'link_type' => LinkType::Internal,
            'link_value' => '/'.fake()->slug(),
            'sort_order' => 10,
            'is_active' => true,
            'open_in_new_tab' => false,
            'nofollow' => false,
            'show_on_desktop' => true,
            'show_on_mobile' => true,
        ];
    }
}
