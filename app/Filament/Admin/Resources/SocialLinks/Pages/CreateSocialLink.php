<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\SocialLinks\Pages;

use App\Filament\Admin\Resources\SocialLinks\SocialLinkResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateSocialLink extends CreateRecord
{
    protected static string $resource = SocialLinkResource::class;
}
