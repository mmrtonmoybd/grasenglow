<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\HeroSlides\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

final class HeroSlideInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ImageEntry::make('image')
                    ->disk('public')
                    ->visibility('public'),
                TextEntry::make('internal_name'),
                TextEntry::make('eyebrow'),
                TextEntry::make('heading'),
                TextEntry::make('subheading'),
                TextEntry::make('body')->columnSpanFull(),
                TextEntry::make('feature_items')
                    ->formatStateUsing(fn (mixed $state): string => collect(is_array($state) ? $state : (is_string($state) ? json_decode($state, true) ?? [] : []))
                        ->filter(fn (mixed $item): bool => is_array($item))
                        ->map(fn (array $item): string => ($item['title'] ?? '').': '.($item['body'] ?? ''))
                        ->implode("\n"))
                    ->columnSpanFull(),
                TextEntry::make('closing_text')->columnSpanFull(),
                TextEntry::make('primary_cta_label'),
                TextEntry::make('primary_cta_url')->url(fn (string $state): string => $state),
                TextEntry::make('secondary_cta_label'),
                TextEntry::make('secondary_cta_url')->url(fn (string $state): string => $state),
                TextEntry::make('duration_seconds')->suffix(' seconds'),
                TextEntry::make('sort_order'),
                IconEntry::make('is_enabled')->boolean(),
                TextEntry::make('source_url')->url(fn (string $state): string => $state),
                TextEntry::make('license'),
                TextEntry::make('attribution'),
            ]);
    }
}
