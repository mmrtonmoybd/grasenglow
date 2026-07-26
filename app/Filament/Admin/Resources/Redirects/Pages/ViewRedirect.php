<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Redirects\Pages;

use App\Filament\Admin\Resources\Redirects\RedirectResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

final class ViewRedirect extends ViewRecord
{
    protected static string $resource = RedirectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
