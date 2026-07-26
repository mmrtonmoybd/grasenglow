<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ProductCollections\Pages;

use App\Filament\Admin\Resources\ProductCollections\ProductCollectionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

final class ViewProductCollection extends ViewRecord
{
    protected static string $resource = ProductCollectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
