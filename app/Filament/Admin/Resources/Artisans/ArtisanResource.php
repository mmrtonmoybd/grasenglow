<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Artisans;

use App\Filament\Admin\Resources\Artisans\Pages\CreateArtisan;
use App\Filament\Admin\Resources\Artisans\Pages\EditArtisan;
use App\Filament\Admin\Resources\Artisans\Pages\ListArtisans;
use App\Filament\Admin\Resources\Artisans\Pages\ViewArtisan;
use App\Filament\Admin\Resources\Artisans\Schemas\ArtisanForm;
use App\Filament\Admin\Resources\Artisans\Schemas\ArtisanInfolist;
use App\Filament\Admin\Resources\Artisans\Tables\ArtisansTable;
use App\Filament\Admin\Resources\CmsResource;
use App\Models\Artisan;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

final class ArtisanResource extends CmsResource
{
    protected static ?string $model = Artisan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ArtisanForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ArtisanInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ArtisansTable::configure($table);
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
            'index' => ListArtisans::route('/'),
            'create' => CreateArtisan::route('/create'),
            'view' => ViewArtisan::route('/{record}'),
            'edit' => EditArtisan::route('/{record}/edit'),
        ];
    }
}
