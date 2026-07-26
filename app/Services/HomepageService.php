<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\BrandValue;
use App\Models\HeroSlide;
use App\Models\ImpactMetric;
use App\Models\Page;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductCollection;
use Illuminate\Support\Facades\Cache;

final class HomepageService
{
    /** @return array<string, mixed> */
    public function data(): array
    {
        return Cache::remember('cms.homepage', now()->addHour(), function (): array {
            $page = Page::query()
                ->with(['sections' => fn ($query) => $query->where('is_enabled', true)->orderBy('sort_order')])
                ->where('slug', 'home')
                ->published()
                ->firstOrFail();

            return [
                'page' => $page,
                'sections' => $page->sections->keyBy(fn ($section) => $section->section_type->value),
                'heroSlides' => HeroSlide::query()
                    ->where('is_enabled', true)
                    ->orderBy('sort_order')
                    ->get(),
                'impactMetrics' => ImpactMetric::query()->active()->orderBy('sort_order')->get(),
                'brandValues' => BrandValue::query()->active()->orderBy('sort_order')->get(),
                'productCategories' => ProductCategory::query()
                    ->active()
                    ->where('is_featured', true)
                    ->orderBy('sort_order')
                    ->limit(6)
                    ->get(),
                'featuredProducts' => Product::query()
                    ->published()
                    ->with('category:id,name,slug')
                    ->where('is_featured', true)
                    ->orderBy('sort_order')
                    ->limit(6)
                    ->get(),
                'featuredCollections' => ProductCollection::query()
                    ->published()
                    ->where('is_featured', true)
                    ->orderBy('sort_order')
                    ->limit(6)
                    ->get(),
            ];
        });
    }
}
