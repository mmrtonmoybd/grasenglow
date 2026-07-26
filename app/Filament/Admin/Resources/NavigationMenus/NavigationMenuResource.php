<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\NavigationMenus;

use App\Filament\Admin\Resources\CmsResource;
use App\Filament\Admin\Resources\NavigationMenus\Pages\CreateNavigationMenu;
use App\Filament\Admin\Resources\NavigationMenus\Pages\EditNavigationMenu;
use App\Filament\Admin\Resources\NavigationMenus\Pages\ListNavigationMenus;
use App\Filament\Admin\Resources\NavigationMenus\Pages\ViewNavigationMenu;
use App\Filament\Admin\Resources\NavigationMenus\Schemas\NavigationMenuForm;
use App\Filament\Admin\Resources\NavigationMenus\Schemas\NavigationMenuInfolist;
use App\Filament\Admin\Resources\NavigationMenus\Tables\NavigationMenusTable;
use App\Models\NavigationMenu;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

final class NavigationMenuResource extends CmsResource
{
    protected static ?string $model = NavigationMenu::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return NavigationMenuForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return NavigationMenuInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NavigationMenusTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListNavigationMenus::route('/'),
            'create' => CreateNavigationMenu::route('/create'),
            'view' => ViewNavigationMenu::route('/{record}'),
            'edit' => EditNavigationMenu::route('/{record}/edit'),
        ];
    }
}
