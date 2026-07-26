<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\PageSections\Pages;

use App\Filament\Admin\Resources\PageSections\PageSectionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

final class ViewPageSection extends ViewRecord
{
    protected static string $resource = PageSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
