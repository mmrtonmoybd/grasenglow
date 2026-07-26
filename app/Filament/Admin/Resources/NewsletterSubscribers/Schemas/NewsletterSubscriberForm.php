<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\NewsletterSubscribers\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

final class NewsletterSubscriberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('source_page')
                    ->default(null),
                DateTimePicker::make('subscribed_at')
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
