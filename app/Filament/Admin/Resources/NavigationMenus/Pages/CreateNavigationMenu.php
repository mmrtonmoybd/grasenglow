<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\NavigationMenus\Pages;

use App\Filament\Admin\Resources\NavigationMenus\NavigationMenuResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateNavigationMenu extends CreateRecord
{
    protected static string $resource = NavigationMenuResource::class;
}
