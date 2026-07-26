<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\PageSections\Pages;

use App\Filament\Admin\Resources\PageSections\PageSectionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

final class ListPageSections extends ListRecords
{
    protected static string $resource = PageSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
