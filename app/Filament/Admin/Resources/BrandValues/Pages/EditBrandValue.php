<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\BrandValues\Pages;

use App\Filament\Admin\Resources\BrandValues\BrandValueResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

final class EditBrandValue extends EditRecord
{
    protected static string $resource = BrandValueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
