<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\BrandValues\Pages;

use App\Filament\Admin\Resources\BrandValues\BrandValueResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

final class ListBrandValues extends ListRecords
{
    protected static string $resource = BrandValueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
