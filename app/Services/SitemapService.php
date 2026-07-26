<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\ImpactStory;
use App\Models\Page;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductCollection;
use App\Models\Project;
use App\Models\ResearchPublication;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

final class SitemapService
{
    /** @return Collection<int, array{url: string, updated_at: ?string}> */
    public function urls(): Collection
    {
        return Cache::remember('cms.sitemap', now()->addHours(6), function (): Collection {
            return collect()
                ->merge($this->publishedUrls(Page::class, 'page.show'))
                ->merge($this->publishedUrls(Product::class, 'products.show'))
                ->merge($this->categoryUrls())
                ->merge($this->publishedUrls(ProductCollection::class, 'collections.show'))
                ->merge($this->publishedUrls(Post::class, 'news.show'))
                ->merge($this->publishedUrls(Project::class, 'projects.show'))
                ->merge($this->publishedUrls(ResearchPublication::class, 'research.show'))
                ->merge($this->publishedUrls(ImpactStory::class, 'impact.show'));
        });
    }

    /** @return Collection<int, array{url: string, updated_at: ?string}> */
    private function publishedUrls(string $model, string $route): Collection
    {
        return $model::query()->published()->select(['slug', 'updated_at'])->get()
            ->map(fn ($record): array => [
                'url' => $record->slug === 'home' ? route('home') : route($route, $record),
                'updated_at' => $record->updated_at?->toAtomString(),
            ]);
    }

    /** @return Collection<int, array{url: string, updated_at: ?string}> */
    private function categoryUrls(): Collection
    {
        return ProductCategory::query()->active()->select(['slug', 'updated_at'])->get()
            ->map(fn (ProductCategory $category): array => [
                'url' => route('product-categories.show', $category),
                'updated_at' => $category->updated_at?->toAtomString(),
            ]);
    }
}
