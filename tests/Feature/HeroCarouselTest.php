<?php

declare(strict_types=1);

use App\Enums\PageTemplate;
use App\Enums\SectionType;
use App\Models\HeroSlide;
use App\Models\Page;
use App\Models\PageSection;
use App\Models\SiteSetting;

it('renders enabled hero slides in order with accessible automatic carousel controls', function () {
    SiteSetting::factory()->create();
    $home = Page::factory()->create([
        'slug' => 'home',
        'page_template' => PageTemplate::Homepage,
    ]);
    PageSection::factory()->for($home)->create([
        'section_type' => SectionType::Hero,
        'internal_name' => 'Hero',
        'sort_order' => 10,
    ]);

    HeroSlide::factory()->create([
        'internal_name' => 'Second slide',
        'heading' => 'Second public slide',
        'sort_order' => 20,
        'duration_seconds' => 3,
    ]);
    HeroSlide::factory()->create([
        'internal_name' => 'First slide',
        'heading' => 'First public slide with an intentionally long title that must never hide its actions',
        'sort_order' => 10,
        'duration_seconds' => 3,
    ]);
    HeroSlide::factory()->create([
        'internal_name' => 'Disabled slide',
        'heading' => 'Hidden public slide',
        'sort_order' => 5,
        'is_enabled' => false,
    ]);

    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSeeInOrder(['First public slide with an intentionally long title', 'Second public slide'])
        ->assertDontSee('Hidden public slide')
        ->assertSee('data-hero-carousel', false)
        ->assertSee('data-duration="3000"', false)
        ->assertSee('object-contain object-center', false)
        ->assertSee('col-start-1 row-start-1', false)
        ->assertDontSee('hero-carousel__slide absolute', false)
        ->assertSee('data-hero-previous', false)
        ->assertSee('data-hero-next', false)
        ->assertSee('aria-live="polite"', false);
});
