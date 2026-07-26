<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ImpactStories\Pages;

use App\Filament\Admin\Resources\ImpactStories\ImpactStoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

final class ListImpactStories extends ListRecords
{
    protected static string $resource = ImpactStoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
