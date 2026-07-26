<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ProductImages\Pages;

use App\Filament\Admin\Resources\ProductImages\ProductImageResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateProductImage extends CreateRecord
{
    protected static string $resource = ProductImageResource::class;
}
