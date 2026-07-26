<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\BrandValues\Pages;

use App\Filament\Admin\Resources\BrandValues\BrandValueResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

final class ViewBrandValue extends ViewRecord
{
    protected static string $resource = BrandValueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
