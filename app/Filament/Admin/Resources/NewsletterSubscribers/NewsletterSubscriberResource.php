<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\NewsletterSubscribers;

use App\Filament\Admin\Resources\CmsResource;
use App\Filament\Admin\Resources\NewsletterSubscribers\Pages\CreateNewsletterSubscriber;
use App\Filament\Admin\Resources\NewsletterSubscribers\Pages\EditNewsletterSubscriber;
use App\Filament\Admin\Resources\NewsletterSubscribers\Pages\ListNewsletterSubscribers;
use App\Filament\Admin\Resources\NewsletterSubscribers\Pages\ViewNewsletterSubscriber;
use App\Filament\Admin\Resources\NewsletterSubscribers\Schemas\NewsletterSubscriberForm;
use App\Filament\Admin\Resources\NewsletterSubscribers\Schemas\NewsletterSubscriberInfolist;
use App\Filament\Admin\Resources\NewsletterSubscribers\Tables\NewsletterSubscribersTable;
use App\Models\NewsletterSubscriber;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

final class NewsletterSubscriberResource extends CmsResource
{
    protected static ?string $model = NewsletterSubscriber::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return NewsletterSubscriberForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return NewsletterSubscriberInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NewsletterSubscribersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListNewsletterSubscribers::route('/'),
            'create' => CreateNewsletterSubscriber::route('/create'),
            'view' => ViewNewsletterSubscriber::route('/{record}'),
            'edit' => EditNewsletterSubscriber::route('/{record}/edit'),
        ];
    }
}
