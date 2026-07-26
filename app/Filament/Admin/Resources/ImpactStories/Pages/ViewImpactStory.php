<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ImpactStories\Pages;

use App\Filament\Admin\Resources\ImpactStories\ImpactStoryResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

final class ViewImpactStory extends ViewRecord
{
    protected static string $resource = ImpactStoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
