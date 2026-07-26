<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\NavigationItem;
use App\Models\SocialLink;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

final class NavigationService
{
    /** @return Collection<int, NavigationItem> */
    public function for(string $location): Collection
    {
        /** @var array<string, Collection<int, NavigationItem>> $menus */
        $menus = Cache::rememberForever('cms.navigation', function (): array {
            return NavigationItem::query()
                ->with(['menu:id,location', 'children'])
                ->whereNull('parent_id')
                ->where('is_active', true)
                ->whereHas('menu', fn ($query) => $query->where('is_active', true))
                ->orderBy('sort_order')
                ->get()
                ->groupBy('menu.location')
                ->all();
        });

        return $menus[$location] ?? collect();
    }

    /** @return Collection<int, SocialLink> */
    public function socialLinks(): Collection
    {
        return Cache::rememberForever(
            'cms.social-links',
            fn (): Collection => SocialLink::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get(),
        );
    }
}
