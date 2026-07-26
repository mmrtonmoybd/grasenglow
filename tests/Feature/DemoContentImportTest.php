<?php

declare(strict_types=1);

use App\Models\Faq;
use App\Models\HeroSlide;
use App\Models\ImpactStory;
use App\Models\Page;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductCollection;
use App\Models\Project;
use App\Models\ResearchPublication;
use App\Services\DemoContentImporter;

beforeEach(function (): void {
    foreach ([
        'home', 'about', 'mission', 'what-we-do', 'products', 'impact', 'projects',
        'research', 'news', 'contact', 'faq', 'privacy-policy', 'terms-and-conditions',
    ] as $slug) {
        Page::factory()->create(['slug' => $slug]);
    }

    foreach ([
        'Quilts', 'Tote Bags', 'Home Décor', 'Sarees', 'Table Linens',
        'Fabric Accessories', 'Floor Mats', 'Sofa Throws', 'Textile Art',
    ] as $name) {
        ProductCategory::factory()->create(['name' => $name, 'slug' => str($name)->slug()]);
    }

    ProductCollection::factory()->create(['name' => 'Ronger Golpo', 'slug' => 'ronger-golpo']);
    ProductCollection::factory()->create(['name' => 'Chitrokatha', 'slug' => 'chitrokatha']);
});

it('fills the demonstration CMS and remains idempotent', function () {
    $importer = app(DemoContentImporter::class);

    $importer->import(downloadImages: false);
    $firstCounts = [
        HeroSlide::query()->count(),
        Product::query()->count(),
        Post::query()->count(),
        Faq::query()->count(),
        Project::query()->count(),
        ResearchPublication::query()->count(),
        ImpactStory::query()->count(),
    ];

    $importer->import(downloadImages: false);

    expect($firstCounts)->toBe([4, 13, 6, 10, 3, 4, 3])
        ->and([
            HeroSlide::query()->count(),
            Product::query()->count(),
            Post::query()->count(),
            Faq::query()->count(),
            Project::query()->count(),
            ResearchPublication::query()->count(),
            ImpactStory::query()->count(),
        ])->toBe($firstCounts)
        ->and(Product::query()->whereNull('featured_image')->count())->toBe(0)
        ->and(Post::query()->whereNull('body')->count())->toBe(0)
        ->and(Page::query()->whereNull('hero_image')->count())->toBe(0);
});
