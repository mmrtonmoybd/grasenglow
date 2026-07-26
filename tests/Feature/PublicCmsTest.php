<?php

declare(strict_types=1);

use App\Enums\ContentStatus;
use App\Enums\PageTemplate;
use App\Enums\SectionType;
use App\Models\BrandValue;
use App\Models\ImpactMetric;
use App\Models\NavigationItem;
use App\Models\NavigationMenu;
use App\Models\Page;
use App\Models\PageSection;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\SiteSetting;

beforeEach(function (): void {
    SiteSetting::factory()->create();
});

it('renders the database-driven homepage in section order', function () {
    $home = Page::factory()->create(['slug' => 'home', 'title' => 'Home', 'page_template' => PageTemplate::Homepage]);
    PageSection::factory()->for($home)->create([
        'section_type' => SectionType::Mission,
        'internal_name' => 'Mission',
        'heading' => 'Second dynamic section',
        'sort_order' => 20,
    ]);
    PageSection::factory()->for($home)->create([
        'section_type' => SectionType::BrandStory,
        'internal_name' => 'Story',
        'heading' => 'First dynamic section',
        'sort_order' => 10,
    ]);

    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSeeInOrder(['First dynamic section', 'Second dynamic section']);
});

it('renders the linked developer credit and omits the announcement bar', function () {
    Page::factory()->create(['slug' => 'home', 'page_template' => PageTemplate::Homepage]);
    SiteSetting::query()->firstOrFail()->update([
        'display_announcement' => true,
        'announcement_text' => 'Announcement must not render',
        'announcement_url' => '/products',
        'announcement_button_label' => 'Explore',
    ]);

    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSee('Developed by')
        ->assertSee('Moshiur Rahman')
        ->assertSee('https://www.facebook.com/mmrtonmoy', false)
        ->assertDontSee('Announcement must not render');
});

it('hides disabled homepage sections and renders metrics values and categories dynamically', function () {
    $home = Page::factory()->create(['slug' => 'home', 'page_template' => PageTemplate::Homepage]);
    PageSection::factory()->for($home)->create([
        'section_type' => SectionType::ImpactMetrics,
        'heading' => 'Verified Impact',
    ]);
    PageSection::factory()->for($home)->create([
        'section_type' => SectionType::ProductCategories,
        'heading' => 'Our Categories',
        'sort_order' => 20,
    ]);
    PageSection::factory()->for($home)->create([
        'section_type' => SectionType::Mission,
        'heading' => 'Must remain hidden',
        'is_enabled' => false,
        'sort_order' => 30,
    ]);
    ImpactMetric::factory()->create(['display_value' => '450+', 'unit' => 'KG']);
    BrandValue::factory()->create();
    ProductCategory::factory()->create(['name' => 'Quilts', 'is_featured' => true]);

    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSee('450+')
        ->assertSee('Quilts')
        ->assertDontSee('Must remain hidden');
});

it('shows published pages and protects draft scheduled and archived pages', function () {
    $published = Page::factory()->create(['slug' => 'visible-page']);
    $draft = Page::factory()->draft()->create(['slug' => 'draft-page']);
    $scheduled = Page::factory()->scheduled()->create(['slug' => 'scheduled-page']);
    $archived = Page::factory()->archived()->create(['slug' => 'archived-page']);

    $this->get(route('page.show', $published))->assertSuccessful()->assertSee($published->title);
    $this->get(route('page.show', $draft))->assertNotFound();
    $this->get(route('page.show', $scheduled))->assertNotFound();
    $this->get(route('page.show', $archived))->assertNotFound();
});

it('shows scheduled pages after their publication time', function () {
    $page = Page::factory()->create([
        'slug' => 'released-schedule',
        'status' => ContentStatus::Scheduled,
        'published_at' => now()->subMinute(),
    ]);

    $this->get(route('page.show', $page))->assertSuccessful();
});

it('protects unpublished products and posts', function () {
    $publishedProduct = Product::factory()->create();
    $draftProduct = Product::factory()->draft()->create();
    $scheduledProduct = Product::factory()->scheduled()->create();
    $publishedPost = Post::factory()->create();
    $draftPost = Post::factory()->draft()->create();

    $this->get(route('products.show', $publishedProduct))->assertSuccessful();
    $this->get(route('products.show', $draftProduct))->assertNotFound();
    $this->get(route('products.show', $scheduledProduct))->assertNotFound();
    $this->get(route('news.show', $publishedPost))->assertSuccessful();
    $this->get(route('news.show', $draftPost))->assertNotFound();
});

it('renders the same active menu records for desktop and mobile', function () {
    Page::factory()->create(['slug' => 'home', 'page_template' => PageTemplate::Homepage]);
    $menu = NavigationMenu::factory()->create(['location' => 'header']);
    NavigationItem::factory()->for($menu, 'menu')->create(['label' => 'Dynamic Navigation', 'link_value' => '/about']);

    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSeeInOrder(['Primary navigation', 'Dynamic Navigation', 'Mobile navigation', 'Dynamic Navigation']);
});

it('replaces empty optional price information with clear enquiry guidance', function () {
    $product = Product::factory()->create(['price' => null, 'currency' => null, 'sku' => null]);

    $this->get(route('products.show', $product))
        ->assertSuccessful()
        ->assertSee('Price and current availability are confirmed by enquiry.')
        ->assertDontSee('BDT')
        ->assertDontSee('SKU');
});
