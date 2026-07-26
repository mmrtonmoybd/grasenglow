<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ProductImages\Pages;

use App\Filament\Admin\Resources\ProductImages\ProductImageResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

final class ViewProductImage extends ViewRecord
{
    protected static string $resource = ProductImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
