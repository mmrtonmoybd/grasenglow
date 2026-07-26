<?php

declare(strict_types=1);

use App\Models\Page;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\Redirect;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

it('enforces unique slugs', function () {
    Page::factory()->create(['slug' => 'unique-page']);

    expect(fn () => Page::factory()->create(['slug' => 'unique-page']))->toThrow(QueryException::class);
});

it('keeps model relationships and foreign key restrictions intact', function () {
    $category = ProductCategory::factory()->create();
    $product = Product::factory()->for($category, 'category')->create();

    expect($product->category->is($category))->toBeTrue()
        ->and(fn () => $category->forceDelete())->toThrow(QueryException::class);
});

it('hides soft-deleted records from public route binding', function () {
    $product = Product::factory()->create();
    $product->delete();

    $this->get('/products/'.$product->slug)->assertNotFound();
});

it('allows only one primary image per product', function () {
    $product = Product::factory()->create();
    $first = ProductImage::factory()->create(['product_id' => $product->id, 'is_primary' => true]);
    $second = ProductImage::factory()->create(['product_id' => $product->id, 'is_primary' => true]);

    expect($first->fresh()->is_primary)->toBeFalse()
        ->and($second->fresh()->is_primary)->toBeTrue();
});

it('creates a safe redirect after a published slug changes', function () {
    $page = Page::factory()->create(['slug' => 'old-page']);
    $page->update(['slug' => 'new-page']);

    expect(Redirect::query()->where('old_path', '/old-page')->where('destination_url', '/new-page')->exists())->toBeTrue();
});

it('rejects self redirects and external redirect destinations', function (array $attributes) {
    expect(fn () => Redirect::query()->create($attributes))->toThrow(ValidationException::class);
})->with([
    'self redirect' => [['old_path' => '/same', 'destination_url' => '/same', 'status_code' => 301]],
    'external destination' => [['old_path' => '/old', 'destination_url' => 'https://example.com', 'status_code' => 301]],
]);
