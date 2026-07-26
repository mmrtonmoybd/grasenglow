<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\NavigationMenus\Pages;

use App\Filament\Admin\Resources\NavigationMenus\NavigationMenuResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

final class ListNavigationMenus extends ListRecords
{
    protected static string $resource = NavigationMenuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
