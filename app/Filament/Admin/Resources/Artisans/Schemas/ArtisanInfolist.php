<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Artisans\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

final class ArtisanInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('display_name')
                    ->placeholder('-'),
                TextEntry::make('role')
                    ->placeholder('-'),
                TextEntry::make('biography')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('photograph')
                    ->placeholder('-'),
                TextEntry::make('photograph_alt')
                    ->placeholder('-'),
                TextEntry::make('quote')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('sort_order')
                    ->numeric(),
                IconEntry::make('is_featured')
                    ->boolean(),
                IconEntry::make('is_active')
                    ->boolean(),
                IconEntry::make('consent_confirmed')
                    ->boolean(),
                TextEntry::make('created_by')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('updated_by')
                    ->numeric()
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
