<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ProductCollections;

use App\Filament\Admin\Resources\CmsResource;
use App\Filament\Admin\Resources\ProductCollections\Pages\CreateProductCollection;
use App\Filament\Admin\Resources\ProductCollections\Pages\EditProductCollection;
use App\Filament\Admin\Resources\ProductCollections\Pages\ListProductCollections;
use App\Filament\Admin\Resources\ProductCollections\Pages\ViewProductCollection;
use App\Filament\Admin\Resources\ProductCollections\Schemas\ProductCollectionForm;
use App\Filament\Admin\Resources\ProductCollections\Schemas\ProductCollectionInfolist;
use App\Filament\Admin\Resources\ProductCollections\Tables\ProductCollectionsTable;
use App\Models\ProductCollection;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

final class ProductCollectionResource extends CmsResource
{
    protected static ?string $model = ProductCollection::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ProductCollectionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ProductCollectionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductCollectionsTable::configure($table);
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
            'index' => ListProductCollections::route('/'),
            'create' => CreateProductCollection::route('/create'),
            'view' => ViewProductCollection::route('/{record}'),
            'edit' => EditProductCollection::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
