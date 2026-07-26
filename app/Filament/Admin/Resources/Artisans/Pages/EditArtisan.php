<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Artisans\Pages;

use App\Filament\Admin\Resources\Artisans\ArtisanResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

final class EditArtisan extends EditRecord
{
    protected static string $resource = ArtisanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
