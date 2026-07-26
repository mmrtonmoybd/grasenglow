<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\HeroSlides;

use App\Filament\Admin\Resources\CmsResource;
use App\Filament\Admin\Resources\HeroSlides\Pages\CreateHeroSlide;
use App\Filament\Admin\Resources\HeroSlides\Pages\EditHeroSlide;
use App\Filament\Admin\Resources\HeroSlides\Pages\ListHeroSlides;
use App\Filament\Admin\Resources\HeroSlides\Pages\ViewHeroSlide;
use App\Filament\Admin\Resources\HeroSlides\Schemas\HeroSlideForm;
use App\Filament\Admin\Resources\HeroSlides\Schemas\HeroSlideInfolist;
use App\Filament\Admin\Resources\HeroSlides\Tables\HeroSlidesTable;
use App\Models\HeroSlide;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

final class HeroSlideResource extends CmsResource
{
    protected static ?string $model = HeroSlide::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return HeroSlideForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return HeroSlideInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HeroSlidesTable::configure($table);
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
            'index' => ListHeroSlides::route('/'),
            'create' => CreateHeroSlide::route('/create'),
            'view' => ViewHeroSlide::route('/{record}'),
            'edit' => EditHeroSlide::route('/{record}/edit'),
        ];
    }
}
