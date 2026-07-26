<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Faqs;

use App\Filament\Admin\Resources\CmsResource;
use App\Filament\Admin\Resources\Faqs\Pages\CreateFaq;
use App\Filament\Admin\Resources\Faqs\Pages\EditFaq;
use App\Filament\Admin\Resources\Faqs\Pages\ListFaqs;
use App\Filament\Admin\Resources\Faqs\Pages\ViewFaq;
use App\Filament\Admin\Resources\Faqs\Schemas\FaqForm;
use App\Filament\Admin\Resources\Faqs\Schemas\FaqInfolist;
use App\Filament\Admin\Resources\Faqs\Tables\FaqsTable;
use App\Models\Faq;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

final class FaqResource extends CmsResource
{
    protected static ?string $model = Faq::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return FaqForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return FaqInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FaqsTable::configure($table);
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
            'index' => ListFaqs::route('/'),
            'create' => CreateFaq::route('/create'),
            'view' => ViewFaq::route('/{record}'),
            'edit' => EditFaq::route('/{record}/edit'),
        ];
    }
}
