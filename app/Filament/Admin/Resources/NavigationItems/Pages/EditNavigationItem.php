<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\NavigationItems\Pages;

use App\Filament\Admin\Resources\NavigationItems\NavigationItemResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

final class EditNavigationItem extends EditRecord
{
    protected static string $resource = NavigationItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
