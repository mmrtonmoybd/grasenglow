<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use App\Models\ContactMessage;
use App\Models\ImpactMetric;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Project;
use App\Models\ResearchPublication;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

final class ContentOverview extends StatsOverviewWidget
{
    protected ?string $pollingInterval = null;

    protected function getStats(): array
    {
        $counts = Cache::remember('cms.dashboard-counts', now()->addMinutes(5), function (): object {
            return DB::query()
                ->selectSub(Product::query()->where('status', 'published')->selectRaw('count(*)'), 'published_products')
                ->selectSub(Product::query()->where('status', 'draft')->selectRaw('count(*)'), 'draft_products')
                ->selectSub(ProductCategory::query()->where('is_active', true)->selectRaw('count(*)'), 'categories')
                ->selectSub(Post::query()->where('status', 'published')->selectRaw('count(*)'), 'published_posts')
                ->selectSub(Project::query()->where('status', 'ongoing')->selectRaw('count(*)'), 'active_projects')
                ->selectSub(ResearchPublication::query()->selectRaw('count(*)'), 'research')
                ->selectSub(ContactMessage::query()->where('status', 'new')->selectRaw('count(*)'), 'new_messages')
                ->selectSub(Product::query()->where('status', 'scheduled')->selectRaw('count(*)'), 'scheduled_products')
                ->first();
        });

        $metrics = ImpactMetric::query()
            ->where('is_active', true)
            ->whereIn('icon', ['recycle', 'people', 'shop', 'paw', 'heart'])
            ->pluck('display_value', 'icon');

        return [
            Stat::make('Published products', $counts->published_products),
            Stat::make('Draft products', $counts->draft_products),
            Stat::make('Product categories', $counts->categories),
            Stat::make('Published news', $counts->published_posts),
            Stat::make('Active projects', $counts->active_projects),
            Stat::make('Research records', $counts->research),
            Stat::make('New messages', $counts->new_messages)->color('danger'),
            Stat::make('Scheduled products', $counts->scheduled_products)->color('warning'),
            Stat::make('Textile waste diverted', ($metrics['recycle'] ?? '—').' KG'),
            Stat::make('Women artisans supported', $metrics['people'] ?? '—'),
            Stat::make('Meals provided', $metrics['paw'] ?? '—'),
            Stat::make('Veterinary treatments', $metrics['heart'] ?? '—'),
        ];
    }
}
