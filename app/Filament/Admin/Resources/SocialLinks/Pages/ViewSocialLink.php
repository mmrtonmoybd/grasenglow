<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\SocialLinks\Pages;

use App\Filament\Admin\Resources\SocialLinks\SocialLinkResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

final class ViewSocialLink extends ViewRecord
{
    protected static string $resource = SocialLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
