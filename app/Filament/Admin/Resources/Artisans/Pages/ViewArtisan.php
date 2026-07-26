<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Artisans\Pages;

use App\Filament\Admin\Resources\Artisans\ArtisanResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

final class ViewArtisan extends ViewRecord
{
    protected static string $resource = ArtisanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
