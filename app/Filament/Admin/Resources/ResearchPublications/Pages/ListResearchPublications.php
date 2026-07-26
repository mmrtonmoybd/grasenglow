<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ResearchPublications\Pages;

use App\Filament\Admin\Resources\ResearchPublications\ResearchPublicationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

final class ListResearchPublications extends ListRecords
{
    protected static string $resource = ResearchPublicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
