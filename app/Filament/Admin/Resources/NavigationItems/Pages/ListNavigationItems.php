<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\NavigationItems\Pages;

use App\Filament\Admin\Resources\NavigationItems\NavigationItemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

final class ListNavigationItems extends ListRecords
{
    protected static string $resource = NavigationItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
