<?php

declare(strict_types=1);

use App\Filament\Admin\Pages\Dashboard;
use App\Filament\Admin\Resources\NavigationMenus\NavigationMenuResource;
use App\Filament\Admin\Resources\Pages\PageResource;
use App\Filament\Admin\Resources\Products\ProductResource;
use Filament\Support\Icons\Heroicon;

it('registers the dashboard and uses distinct resource navigation icons', function () {
    expect(Dashboard::shouldRegisterNavigation())->toBeTrue()
        ->and(Dashboard::getNavigationIcon())->toBe(Heroicon::OutlinedHome)
        ->and(PageResource::getNavigationIcon())->toBe(Heroicon::OutlinedDocumentText)
        ->and(NavigationMenuResource::getNavigationIcon())->toBe(Heroicon::OutlinedBars3)
        ->and(ProductResource::getNavigationIcon())->toBe(Heroicon::OutlinedShoppingBag);
});
