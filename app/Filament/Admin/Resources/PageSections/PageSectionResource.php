<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\PageSections;

use App\Filament\Admin\Resources\CmsResource;
use App\Filament\Admin\Resources\PageSections\Pages\CreatePageSection;
use App\Filament\Admin\Resources\PageSections\Pages\EditPageSection;
use App\Filament\Admin\Resources\PageSections\Pages\ListPageSections;
use App\Filament\Admin\Resources\PageSections\Pages\ViewPageSection;
use App\Filament\Admin\Resources\PageSections\Schemas\PageSectionForm;
use App\Filament\Admin\Resources\PageSections\Schemas\PageSectionInfolist;
use App\Filament\Admin\Resources\PageSections\Tables\PageSectionsTable;
use App\Models\PageSection;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

final class PageSectionResource extends CmsResource
{
    protected static ?string $model = PageSection::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return PageSectionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PageSectionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PageSectionsTable::configure($table);
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
            'index' => ListPageSections::route('/'),
            'create' => CreatePageSection::route('/create'),
            'view' => ViewPageSection::route('/{record}'),
            'edit' => EditPageSection::route('/{record}/edit'),
        ];
    }
}
