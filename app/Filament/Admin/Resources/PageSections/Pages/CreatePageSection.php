<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\PageSections\Pages;

use App\Filament\Admin\Resources\PageSections\PageSectionResource;
use Filament\Resources\Pages\CreateRecord;

final class CreatePageSection extends CreateRecord
{
    protected static string $resource = PageSectionResource::class;
}
