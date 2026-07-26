<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\PostCategories;

use App\Filament\Admin\Resources\CmsResource;
use App\Filament\Admin\Resources\PostCategories\Pages\CreatePostCategory;
use App\Filament\Admin\Resources\PostCategories\Pages\EditPostCategory;
use App\Filament\Admin\Resources\PostCategories\Pages\ListPostCategories;
use App\Filament\Admin\Resources\PostCategories\Pages\ViewPostCategory;
use App\Filament\Admin\Resources\PostCategories\Schemas\PostCategoryForm;
use App\Filament\Admin\Resources\PostCategories\Schemas\PostCategoryInfolist;
use App\Filament\Admin\Resources\PostCategories\Tables\PostCategoriesTable;
use App\Models\PostCategory;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

final class PostCategoryResource extends CmsResource
{
    protected static ?string $model = PostCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return PostCategoryForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PostCategoryInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PostCategoriesTable::configure($table);
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
            'index' => ListPostCategories::route('/'),
            'create' => CreatePostCategory::route('/create'),
            'view' => ViewPostCategory::route('/{record}'),
            'edit' => EditPostCategory::route('/{record}/edit'),
        ];
    }
}
