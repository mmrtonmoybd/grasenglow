<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ResearchPublications\Pages;

use App\Filament\Admin\Resources\ResearchPublications\ResearchPublicationResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

final class ViewResearchPublication extends ViewRecord
{
    protected static string $resource = ResearchPublicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
