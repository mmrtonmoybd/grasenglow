<?php

declare(strict_types=1);

use App\Enums\ContentStatus;
use App\Models\Page;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\SiteSetting;

beforeEach(function (): void {
    SiteSetting::factory()->create();
});

it('renders the product listing when a product category has been soft deleted', function () {
    $category = ProductCategory::factory()->create(['name' => 'Woven Baskets']);
    $product = Product::factory()->for($category, 'category')->create(['name' => 'Jute Basket']);

    $category->delete();

    $this->get(route('products.index'))
        ->assertSuccessful()
        ->assertSee('Jute Basket')
        ->assertDontSee('Woven Baskets');

    $this->get(route('products.show', $product))
        ->assertSuccessful()
        ->assertSee('Jute Basket');
});

it('renders page body markdown as html', function () {
    $page = Page::factory()->create([
        'slug' => 'our-story',
        'body' => "## Our roots\n\nWe work with **local artisans**.\n\n- Handwoven\n- Fair trade",
    ]);

    $response = $this->get(route('page.show', $page));

    $response->assertSuccessful()
        ->assertSee('<h2>Our roots</h2>', false)
        ->assertSee('<strong>local artisans</strong>', false)
        ->assertSee('<li>Handwoven</li>', false);
});

it('renders post body markdown as html', function () {
    $post = Post::factory()->create([
        'post_category_id' => PostCategory::factory(),
        'status' => ContentStatus::Published,
        'published_at' => now()->subDay(),
        'body' => 'Read our [impact report](https://example.com).',
    ]);

    $this->get(route('news.show', $post))
        ->assertSuccessful()
        ->assertSee('<a href="https://example.com">impact report</a>', false);
});

it('strips raw html from markdown body content', function () {
    $page = Page::factory()->create([
        'slug' => 'safety',
        'body' => 'Hello <script>alert(1)</script> world',
    ]);

    $this->get(route('page.show', $page))
        ->assertSuccessful()
        ->assertDontSee('<script>alert(1)</script>', false);
});

it('renders uploaded images inside markdown body content', function () {
    $page = Page::factory()->create([
        'slug' => 'gallery',
        'body' => "Our workshop:\n\n![Artisans at work](/storage/cms/markdown/workshop.jpg)",
    ]);

    $this->get(route('page.show', $page))
        ->assertSuccessful()
        ->assertSee('src="/storage/cms/markdown/workshop.jpg"', false)
        ->assertSee('alt="Artisans at work"', false)
        ->assertSee('loading="lazy"', false)
        ->assertSee('decoding="async"', false);
});
