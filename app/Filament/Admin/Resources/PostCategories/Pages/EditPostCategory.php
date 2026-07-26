<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\PostCategories\Pages;

use App\Filament\Admin\Resources\PostCategories\PostCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

final class EditPostCategory extends EditRecord
{
    protected static string $resource = PostCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
