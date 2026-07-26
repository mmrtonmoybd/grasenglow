<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\NewsletterSubscribers\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

final class NewsletterSubscriberInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('source_page')
                    ->placeholder('-'),
                TextEntry::make('subscribed_at')
                    ->dateTime(),
                IconEntry::make('is_active')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
