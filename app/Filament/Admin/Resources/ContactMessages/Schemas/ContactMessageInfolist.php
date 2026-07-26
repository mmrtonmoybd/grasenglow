<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ContactMessages\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

final class ContactMessageInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('phone')
                    ->placeholder('-'),
                TextEntry::make('subject'),
                TextEntry::make('message')
                    ->columnSpanFull(),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('source_page')
                    ->placeholder('-'),
                TextEntry::make('submitted_at')
                    ->dateTime(),
                TextEntry::make('assigned_to')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('internal_notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('replied_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('archived_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
