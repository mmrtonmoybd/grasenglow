<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Pages\Schemas;

use App\Models\Page;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

final class PageInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title'),
                TextEntry::make('slug'),
                TextEntry::make('navigation_label')
                    ->placeholder('-'),
                TextEntry::make('page_template')
                    ->badge(),
                TextEntry::make('excerpt')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('body')
                    ->markdown()
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('hero_title')
                    ->placeholder('-'),
                TextEntry::make('hero_subtitle')
                    ->placeholder('-'),
                TextEntry::make('hero_description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                ImageEntry::make('hero_image')
                    ->placeholder('-'),
                ImageEntry::make('hero_image_alt')
                    ->placeholder('-'),
                TextEntry::make('primary_cta_label')
                    ->placeholder('-'),
                TextEntry::make('primary_cta_url')
                    ->placeholder('-'),
                TextEntry::make('secondary_cta_label')
                    ->placeholder('-'),
                TextEntry::make('secondary_cta_url')
                    ->placeholder('-'),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('published_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('sort_order')
                    ->numeric(),
                IconEntry::make('is_indexable')
                    ->boolean(),
                TextEntry::make('canonical_url')
                    ->placeholder('-'),
                TextEntry::make('meta_title')
                    ->placeholder('-'),
                TextEntry::make('meta_description')
                    ->placeholder('-'),
                TextEntry::make('meta_keywords')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('open_graph_title')
                    ->placeholder('-'),
                TextEntry::make('open_graph_description')
                    ->placeholder('-'),
                ImageEntry::make('open_graph_image')
                    ->placeholder('-'),
                TextEntry::make('twitter_card_type'),
                TextEntry::make('schema_type')
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
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Page $record): bool => $record->trashed()),
            ]);
    }
}
