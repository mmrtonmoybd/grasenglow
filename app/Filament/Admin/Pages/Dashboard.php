<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages;

use BackedEnum;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

final class Dashboard extends BaseDashboard
{
    protected static string|null|UnitEnum $navigationGroup = null;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHome;

    protected static ?int $navigationSort = -100;
}
