<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ProductImages;

use App\Filament\Admin\Resources\CmsResource;
use App\Filament\Admin\Resources\ProductImages\Pages\CreateProductImage;
use App\Filament\Admin\Resources\ProductImages\Pages\EditProductImage;
use App\Filament\Admin\Resources\ProductImages\Pages\ListProductImages;
use App\Filament\Admin\Resources\ProductImages\Pages\ViewProductImage;
use App\Filament\Admin\Resources\ProductImages\Schemas\ProductImageForm;
use App\Filament\Admin\Resources\ProductImages\Schemas\ProductImageInfolist;
use App\Filament\Admin\Resources\ProductImages\Tables\ProductImagesTable;
use App\Models\ProductImage;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

final class ProductImageResource extends CmsResource
{
    protected static ?string $model = ProductImage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ProductImageForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ProductImageInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductImagesTable::configure($table);
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
            'index' => ListProductImages::route('/'),
            'create' => CreateProductImage::route('/create'),
            'view' => ViewProductImage::route('/{record}'),
            'edit' => EditProductImage::route('/{record}/edit'),
        ];
    }
}
