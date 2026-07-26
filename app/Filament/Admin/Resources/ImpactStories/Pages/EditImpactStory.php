<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ImpactStories\Pages;

use App\Filament\Admin\Resources\ImpactStories\ImpactStoryResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

final class EditImpactStory extends EditRecord
{
    protected static string $resource = ImpactStoryResource::class;

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
