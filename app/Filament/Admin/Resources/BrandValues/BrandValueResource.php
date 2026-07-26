<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\BrandValues;

use App\Filament\Admin\Resources\BrandValues\Pages\CreateBrandValue;
use App\Filament\Admin\Resources\BrandValues\Pages\EditBrandValue;
use App\Filament\Admin\Resources\BrandValues\Pages\ListBrandValues;
use App\Filament\Admin\Resources\BrandValues\Pages\ViewBrandValue;
use App\Filament\Admin\Resources\BrandValues\Schemas\BrandValueForm;
use App\Filament\Admin\Resources\BrandValues\Schemas\BrandValueInfolist;
use App\Filament\Admin\Resources\BrandValues\Tables\BrandValuesTable;
use App\Filament\Admin\Resources\CmsResource;
use App\Models\BrandValue;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

final class BrandValueResource extends CmsResource
{
    protected static ?string $model = BrandValue::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return BrandValueForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BrandValueInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BrandValuesTable::configure($table);
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
            'index' => ListBrandValues::route('/'),
            'create' => CreateBrandValue::route('/create'),
            'view' => ViewBrandValue::route('/{record}'),
            'edit' => EditBrandValue::route('/{record}/edit'),
        ];
    }
}
