<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ProductCollections\Pages;

use App\Filament\Admin\Resources\ProductCollections\ProductCollectionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

final class ListProductCollections extends ListRecords
{
    protected static string $resource = ProductCollectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
