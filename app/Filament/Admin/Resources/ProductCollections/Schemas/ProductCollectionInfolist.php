<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ProductCollections\Schemas;

use App\Models\ProductCollection;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

final class ProductCollectionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('slug'),
                TextEntry::make('subtitle')
                    ->placeholder('-'),
                TextEntry::make('short_description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                ImageEntry::make('cover_image')
                    ->placeholder('-'),
                ImageEntry::make('cover_image_alt')
                    ->placeholder('-'),
                ImageEntry::make('banner_image')
                    ->placeholder('-'),
                ImageEntry::make('banner_image_alt')
                    ->placeholder('-'),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('published_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('sort_order')
                    ->numeric(),
                IconEntry::make('is_featured')
                    ->boolean(),
                TextEntry::make('meta_title')
                    ->placeholder('-'),
                TextEntry::make('meta_description')
                    ->placeholder('-'),
                TextEntry::make('meta_keywords')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('canonical_url')
                    ->placeholder('-'),
                ImageEntry::make('open_graph_image')
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
                    ->visible(fn (ProductCollection $record): bool => $record->trashed()),
            ]);
    }
}
