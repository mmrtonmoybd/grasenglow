<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ProductImages\Pages;

use App\Filament\Admin\Resources\ProductImages\ProductImageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

final class ListProductImages extends ListRecords
{
    protected static string $resource = ProductImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
