<?php

declare(strict_types=1);

use App\Enums\PageTemplate;
use App\Models\Faq;
use App\Models\NavigationItem;
use App\Models\NavigationMenu;
use App\Models\Page;
use App\Models\SiteSetting;
use App\Services\NavigationService;
use App\Services\SiteSettingsService;
use Illuminate\Support\Facades\Cache;

beforeEach(function (): void {
    SiteSetting::factory()->create([
        'default_meta_title' => 'Default SEO title',
        'canonical_domain' => 'https://grace-glow.test',
    ]);
});

it('renders record SEO title description canonical and open graph metadata', function () {
    $page = Page::factory()->create([
        'slug' => 'seo-page',
        'meta_title' => 'Specific SEO title',
        'meta_description' => 'Specific SEO description',
        'canonical_url' => 'https://grace-glow.test/seo-page',
        'open_graph_title' => 'Open Graph title',
    ]);

    $this->get(route('page.show', $page))
        ->assertSuccessful()
        ->assertSee('<title>Specific SEO title</title>', false)
        ->assertSee('Specific SEO description')
        ->assertSee('https://grace-glow.test/seo-page')
        ->assertSee('property="og:title"', false);
});

it('includes published pages and excludes draft and future scheduled pages from the sitemap', function () {
    $published = Page::factory()->create(['slug' => 'published-sitemap']);
    Page::factory()->draft()->create(['slug' => 'draft-sitemap']);
    Page::factory()->scheduled()->create(['slug' => 'future-sitemap']);

    $this->get(route('sitemap'))
        ->assertSuccessful()
        ->assertSee(route('page.show', $published), false)
        ->assertDontSee('draft-sitemap')
        ->assertDontSee('future-sitemap');
});

it('emits valid faq schema only when visible faqs are rendered', function () {
    $faqPage = Page::factory()->create(['slug' => 'faq', 'page_template' => PageTemplate::Faq]);
    Faq::factory()->create(['question' => 'Visible question?', 'is_active' => true]);
    Faq::factory()->create(['question' => 'Hidden question?', 'is_active' => false]);

    $response = $this->get(route('page.show', $faqPage))
        ->assertSuccessful()
        ->assertSee('"@type":"FAQPage"', false)
        ->assertSee('Visible question?')
        ->assertDontSee('Hidden question?');

    preg_match_all('/<script type="application\\/ld\\+json">(.*?)<\\/script>/s', $response->getContent(), $matches);
    foreach ($matches[1] as $json) {
        expect(json_decode($json, true, flags: JSON_THROW_ON_ERROR))->toBeArray();
    }
});

it('does not emit fake product offer fields', function () {
    $product = App\Models\Product::factory()->create(['price' => null, 'currency' => null, 'sku' => null]);

    $this->get(route('products.show', $product))
        ->assertSuccessful()
        ->assertDontSee('"offers"', false)
        ->assertDontSee('"aggregateRating"', false);
});

it('invalidates settings and navigation caches after updates', function () {
    $settingsService = app(SiteSettingsService::class);
    $settings = $settingsService->get();
    expect($settings->site_name)->toBe('Grace & Glow');

    SiteSetting::query()->first()->update(['site_name' => 'Updated Grace & Glow']);
    expect(Cache::has('cms.site-settings'))->toBeFalse()
        ->and($settingsService->get()->site_name)->toBe('Updated Grace & Glow');

    $menu = NavigationMenu::factory()->create(['location' => 'header']);
    $navigation = app(NavigationService::class);
    expect($navigation->for('header'))->toBeEmpty();

    NavigationItem::factory()->for($menu, 'menu')->create(['label' => 'Fresh link']);
    expect(Cache::has('cms.navigation'))->toBeFalse()
        ->and($navigation->for('header')->pluck('label'))->toContain('Fresh link');
});
