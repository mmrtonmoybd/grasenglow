<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\SocialLinks\Pages;

use App\Filament\Admin\Resources\SocialLinks\SocialLinkResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

final class EditSocialLink extends EditRecord
{
    protected static string $resource = SocialLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
