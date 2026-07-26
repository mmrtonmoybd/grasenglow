<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Partners;

use App\Filament\Admin\Resources\CmsResource;
use App\Filament\Admin\Resources\Partners\Pages\CreatePartner;
use App\Filament\Admin\Resources\Partners\Pages\EditPartner;
use App\Filament\Admin\Resources\Partners\Pages\ListPartners;
use App\Filament\Admin\Resources\Partners\Pages\ViewPartner;
use App\Filament\Admin\Resources\Partners\Schemas\PartnerForm;
use App\Filament\Admin\Resources\Partners\Schemas\PartnerInfolist;
use App\Filament\Admin\Resources\Partners\Tables\PartnersTable;
use App\Models\Partner;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

final class PartnerResource extends CmsResource
{
    protected static ?string $model = Partner::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return PartnerForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PartnerInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PartnersTable::configure($table);
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
            'index' => ListPartners::route('/'),
            'create' => CreatePartner::route('/create'),
            'view' => ViewPartner::route('/{record}'),
            'edit' => EditPartner::route('/{record}/edit'),
        ];
    }
}
