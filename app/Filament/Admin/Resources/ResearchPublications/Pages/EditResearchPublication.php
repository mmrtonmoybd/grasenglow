<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ResearchPublications\Pages;

use App\Filament\Admin\Resources\ResearchPublications\ResearchPublicationResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

final class EditResearchPublication extends EditRecord
{
    protected static string $resource = ResearchPublicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
