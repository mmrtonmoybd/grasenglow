<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ImpactStories\Pages;

use App\Filament\Admin\Resources\ImpactStories\ImpactStoryResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateImpactStory extends CreateRecord
{
    protected static string $resource = ImpactStoryResource::class;
}
