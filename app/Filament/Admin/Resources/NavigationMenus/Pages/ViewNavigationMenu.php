<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\NavigationMenus\Pages;

use App\Filament\Admin\Resources\NavigationMenus\NavigationMenuResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

final class ViewNavigationMenu extends ViewRecord
{
    protected static string $resource = NavigationMenuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
