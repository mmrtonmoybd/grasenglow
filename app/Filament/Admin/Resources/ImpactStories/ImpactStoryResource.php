<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ImpactStories;

use App\Filament\Admin\Resources\CmsResource;
use App\Filament\Admin\Resources\ImpactStories\Pages\CreateImpactStory;
use App\Filament\Admin\Resources\ImpactStories\Pages\EditImpactStory;
use App\Filament\Admin\Resources\ImpactStories\Pages\ListImpactStories;
use App\Filament\Admin\Resources\ImpactStories\Pages\ViewImpactStory;
use App\Filament\Admin\Resources\ImpactStories\Schemas\ImpactStoryForm;
use App\Filament\Admin\Resources\ImpactStories\Schemas\ImpactStoryInfolist;
use App\Filament\Admin\Resources\ImpactStories\Tables\ImpactStoriesTable;
use App\Models\ImpactStory;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

final class ImpactStoryResource extends CmsResource
{
    protected static ?string $model = ImpactStory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ImpactStoryForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ImpactStoryInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ImpactStoriesTable::configure($table);
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
            'index' => ListImpactStories::route('/'),
            'create' => CreateImpactStory::route('/create'),
            'view' => ViewImpactStory::route('/{record}'),
            'edit' => EditImpactStory::route('/{record}/edit'),
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
