<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\NavigationMenus\Pages;

use App\Filament\Admin\Resources\NavigationMenus\NavigationMenuResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

final class EditNavigationMenu extends EditRecord
{
    protected static string $resource = NavigationMenuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
