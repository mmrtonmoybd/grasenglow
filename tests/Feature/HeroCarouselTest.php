<?php

declare(strict_types=1);

use App\Enums\PageTemplate;
use App\Enums\SectionType;
use App\Models\HeroSlide;
use App\Models\Page;
use App\Models\PageSection;
use App\Models\SiteSetting;

it('renders static hero showcase from first enabled hero record with editable feature rows', function () {
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
        'heading' => 'Static hero showcase heading',
        'closing_text' => 'Closing line for hero showcase',
        'feature_items' => [
            [
                'icon' => 'recycle',
                'tone' => 'forest',
                'title' => 'First editable feature',
                'body' => 'First feature description',
            ],
        ],
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
        ->assertSee('Static hero showcase heading')
        ->assertSee('First editable feature')
        ->assertSee('Closing line for hero showcase')
        ->assertDontSee('Second public slide')
        ->assertDontSee('Hidden public slide')
        ->assertDontSee('data-hero-carousel', false)
        ->assertDontSee('data-hero-previous', false)
        ->assertDontSee('data-hero-next', false)
        ->assertSee('lg:grid-cols-[39%_61%]', false)
        ->assertSee('class="block h-full w-full object-cover"', false);
});
