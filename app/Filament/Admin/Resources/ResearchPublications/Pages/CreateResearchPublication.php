<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ResearchPublications\Pages;

use App\Filament\Admin\Resources\ResearchPublications\ResearchPublicationResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateResearchPublication extends CreateRecord
{
    protected static string $resource = ResearchPublicationResource::class;
}
