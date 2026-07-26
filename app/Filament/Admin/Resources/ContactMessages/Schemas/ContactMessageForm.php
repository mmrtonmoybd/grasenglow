<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ContactMessages\Schemas;

use App\Enums\ContactMessageStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

final class ContactMessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->disabled()
                    ->dehydrated(false)
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->disabled()
                    ->dehydrated(false)
                    ->required(),
                TextInput::make('phone')
                    ->tel()
                    ->disabled()
                    ->dehydrated(false)
                    ->default(null),
                TextInput::make('subject')
                    ->disabled()
                    ->dehydrated(false)
                    ->required(),
                Textarea::make('message')
                    ->disabled()
                    ->dehydrated(false)
                    ->required()
                    ->columnSpanFull(),
                Select::make('status')
                    ->options(ContactMessageStatus::class)
                    ->default('new')
                    ->required(),
                TextInput::make('source_page')
                    ->disabled()
                    ->dehydrated(false)
                    ->default(null),
                DateTimePicker::make('submitted_at')
                    ->disabled()
                    ->dehydrated(false)
                    ->required(),
                Select::make('assigned_to')
                    ->relationship('assignee', 'name')
                    ->searchable()
                    ->preload(),
                Textarea::make('internal_notes')
                    ->default(null)
                    ->columnSpanFull(),
                DateTimePicker::make('replied_at'),
                DateTimePicker::make('archived_at'),
            ]);
    }
}
