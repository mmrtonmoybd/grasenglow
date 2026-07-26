<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ImpactMetrics\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

final class ImpactMetricInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title'),
                TextEntry::make('numeric_value')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('display_value'),
                TextEntry::make('unit')
                    ->placeholder('-'),
                TextEntry::make('prefix')
                    ->placeholder('-'),
                TextEntry::make('suffix')
                    ->placeholder('-'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('icon')
                    ->placeholder('-'),
                ImageEntry::make('image')
                    ->placeholder('-'),
                ImageEntry::make('image_alt')
                    ->placeholder('-'),
                TextEntry::make('sort_order')
                    ->numeric(),
                IconEntry::make('is_active')
                    ->boolean(),
                TextEntry::make('last_verified_at')
                    ->date()
                    ->placeholder('-'),
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
