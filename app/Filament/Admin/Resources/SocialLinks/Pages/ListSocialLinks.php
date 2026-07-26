<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\SocialLinks\Pages;

use App\Filament\Admin\Resources\SocialLinks\SocialLinkResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

final class ListSocialLinks extends ListRecords
{
    protected static string $resource = SocialLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
