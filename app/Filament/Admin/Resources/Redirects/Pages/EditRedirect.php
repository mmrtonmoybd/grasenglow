<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Redirects\Pages;

use App\Filament\Admin\Resources\Redirects\RedirectResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

final class EditRedirect extends EditRecord
{
    protected static string $resource = RedirectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
