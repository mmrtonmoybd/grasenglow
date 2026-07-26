<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Artisans\Pages;

use App\Filament\Admin\Resources\Artisans\ArtisanResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateArtisan extends CreateRecord
{
    protected static string $resource = ArtisanResource::class;
}
