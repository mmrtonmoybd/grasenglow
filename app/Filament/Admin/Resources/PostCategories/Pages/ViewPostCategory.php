<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\PostCategories\Pages;

use App\Filament\Admin\Resources\PostCategories\PostCategoryResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

final class ViewPostCategory extends ViewRecord
{
    protected static string $resource = PostCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
