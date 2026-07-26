<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\NavigationItems\Pages;

use App\Filament\Admin\Resources\NavigationItems\NavigationItemResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

final class ViewNavigationItem extends ViewRecord
{
    protected static string $resource = NavigationItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
