<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Artisans\Pages;

use App\Filament\Admin\Resources\Artisans\ArtisanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

final class ListArtisans extends ListRecords
{
    protected static string $resource = ArtisanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
