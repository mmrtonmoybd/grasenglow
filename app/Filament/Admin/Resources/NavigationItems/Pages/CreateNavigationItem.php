<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\NavigationItems\Pages;

use App\Filament\Admin\Resources\NavigationItems\NavigationItemResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateNavigationItem extends CreateRecord
{
    protected static string $resource = NavigationItemResource::class;
}
