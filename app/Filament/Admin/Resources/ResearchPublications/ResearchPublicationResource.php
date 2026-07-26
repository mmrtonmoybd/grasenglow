<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ResearchPublications;

use App\Filament\Admin\Resources\CmsResource;
use App\Filament\Admin\Resources\ResearchPublications\Pages\CreateResearchPublication;
use App\Filament\Admin\Resources\ResearchPublications\Pages\EditResearchPublication;
use App\Filament\Admin\Resources\ResearchPublications\Pages\ListResearchPublications;
use App\Filament\Admin\Resources\ResearchPublications\Pages\ViewResearchPublication;
use App\Filament\Admin\Resources\ResearchPublications\Schemas\ResearchPublicationForm;
use App\Filament\Admin\Resources\ResearchPublications\Schemas\ResearchPublicationInfolist;
use App\Filament\Admin\Resources\ResearchPublications\Tables\ResearchPublicationsTable;
use App\Models\ResearchPublication;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

final class ResearchPublicationResource extends CmsResource
{
    protected static ?string $model = ResearchPublication::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ResearchPublicationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ResearchPublicationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ResearchPublicationsTable::configure($table);
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
            'index' => ListResearchPublications::route('/'),
            'create' => CreateResearchPublication::route('/create'),
            'view' => ViewResearchPublication::route('/{record}'),
            'edit' => EditResearchPublication::route('/{record}/edit'),
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
