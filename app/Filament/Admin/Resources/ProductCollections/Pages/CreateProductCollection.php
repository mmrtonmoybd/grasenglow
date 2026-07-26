<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ProductCollections\Pages;

use App\Filament\Admin\Resources\ProductCollections\ProductCollectionResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateProductCollection extends CreateRecord
{
    protected static string $resource = ProductCollectionResource::class;
}
