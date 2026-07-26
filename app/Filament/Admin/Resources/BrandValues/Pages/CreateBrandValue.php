<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\BrandValues\Pages;

use App\Filament\Admin\Resources\BrandValues\BrandValueResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateBrandValue extends CreateRecord
{
    protected static string $resource = BrandValueResource::class;
}
