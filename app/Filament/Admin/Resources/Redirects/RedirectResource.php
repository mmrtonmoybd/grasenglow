<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Redirects;

use App\Filament\Admin\Resources\CmsResource;
use App\Filament\Admin\Resources\Redirects\Pages\CreateRedirect;
use App\Filament\Admin\Resources\Redirects\Pages\EditRedirect;
use App\Filament\Admin\Resources\Redirects\Pages\ListRedirects;
use App\Filament\Admin\Resources\Redirects\Pages\ViewRedirect;
use App\Filament\Admin\Resources\Redirects\Schemas\RedirectForm;
use App\Filament\Admin\Resources\Redirects\Schemas\RedirectInfolist;
use App\Filament\Admin\Resources\Redirects\Tables\RedirectsTable;
use App\Models\Redirect;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

final class RedirectResource extends CmsResource
{
    protected static ?string $model = Redirect::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return RedirectForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return RedirectInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RedirectsTable::configure($table);
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
            'index' => ListRedirects::route('/'),
            'create' => CreateRedirect::route('/create'),
            'view' => ViewRedirect::route('/{record}'),
            'edit' => EditRedirect::route('/{record}/edit'),
        ];
    }
}
