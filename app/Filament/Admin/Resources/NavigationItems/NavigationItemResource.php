<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\NavigationItems;

use App\Filament\Admin\Resources\CmsResource;
use App\Filament\Admin\Resources\NavigationItems\Pages\CreateNavigationItem;
use App\Filament\Admin\Resources\NavigationItems\Pages\EditNavigationItem;
use App\Filament\Admin\Resources\NavigationItems\Pages\ListNavigationItems;
use App\Filament\Admin\Resources\NavigationItems\Pages\ViewNavigationItem;
use App\Filament\Admin\Resources\NavigationItems\Schemas\NavigationItemForm;
use App\Filament\Admin\Resources\NavigationItems\Schemas\NavigationItemInfolist;
use App\Filament\Admin\Resources\NavigationItems\Tables\NavigationItemsTable;
use App\Models\NavigationItem;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

final class NavigationItemResource extends CmsResource
{
    protected static ?string $model = NavigationItem::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return NavigationItemForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return NavigationItemInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NavigationItemsTable::configure($table);
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
            'index' => ListNavigationItems::route('/'),
            'create' => CreateNavigationItem::route('/create'),
            'view' => ViewNavigationItem::route('/{record}'),
            'edit' => EditNavigationItem::route('/{record}/edit'),
        ];
    }
}
