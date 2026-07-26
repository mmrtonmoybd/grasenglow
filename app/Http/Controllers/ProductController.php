<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductCollection;
use App\Services\SeoService;
use Illuminate\Contracts\View\View;

final readonly class ProductController
{
    public function __construct(private SeoService $seo) {}

    public function index(): View
    {
        return view('catalog.index', [
            'products' => Product::query()->published()->with('category:id,name,slug')->latest('published_at')->paginate(12),
            'categories' => ProductCategory::query()->active()->orderBy('sort_order')->get(),
            'seo' => $this->seo->for(fallbackTitle: 'Our Products'),
        ]);
    }

    public function show(Product $product): View
    {
        abort_unless($product->isPubliclyVisible(), 404);
        $product->load(['category', 'collections', 'images', 'relatedProducts' => fn ($query) => $query->published()]);

        return view('catalog.show', ['product' => $product, 'seo' => $this->seo->for($product)]);
    }

    public function category(ProductCategory $productCategory): View
    {
        abort_unless($productCategory->is_active, 404);

        return view('catalog.category', [
            'category' => $productCategory,
            'products' => $productCategory->products()->published()->with('category:id,name,slug')->paginate(12),
            'seo' => $this->seo->for($productCategory),
        ]);
    }

    public function collection(ProductCollection $collection): View
    {
        abort_unless($collection->isPubliclyVisible(), 404);

        return view('catalog.collection', [
            'collection' => $collection,
            'products' => $collection->products()->published()->with('category:id,name,slug')->paginate(12),
            'seo' => $this->seo->for($collection),
        ]);
    }
}
