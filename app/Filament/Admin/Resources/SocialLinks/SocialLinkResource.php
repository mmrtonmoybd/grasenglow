<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\SocialLinks;

use App\Filament\Admin\Resources\CmsResource;
use App\Filament\Admin\Resources\SocialLinks\Pages\CreateSocialLink;
use App\Filament\Admin\Resources\SocialLinks\Pages\EditSocialLink;
use App\Filament\Admin\Resources\SocialLinks\Pages\ListSocialLinks;
use App\Filament\Admin\Resources\SocialLinks\Pages\ViewSocialLink;
use App\Filament\Admin\Resources\SocialLinks\Schemas\SocialLinkForm;
use App\Filament\Admin\Resources\SocialLinks\Schemas\SocialLinkInfolist;
use App\Filament\Admin\Resources\SocialLinks\Tables\SocialLinksTable;
use App\Models\SocialLink;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

final class SocialLinkResource extends CmsResource
{
    protected static ?string $model = SocialLink::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return SocialLinkForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SocialLinkInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SocialLinksTable::configure($table);
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
            'index' => ListSocialLinks::route('/'),
            'create' => CreateSocialLink::route('/create'),
            'view' => ViewSocialLink::route('/{record}'),
            'edit' => EditSocialLink::route('/{record}/edit'),
        ];
    }
}
