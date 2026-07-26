<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ProductCategories\Schemas;

use App\Models\ProductCategory;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

final class ProductCategoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('parent.name')
                    ->label('Parent')
                    ->placeholder('-'),
                TextEntry::make('name'),
                TextEntry::make('slug'),
                TextEntry::make('short_description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                ImageEntry::make('featured_image')
                    ->placeholder('-'),
                ImageEntry::make('featured_image_alt')
                    ->placeholder('-'),
                ImageEntry::make('banner_image')
                    ->placeholder('-'),
                ImageEntry::make('banner_image_alt')
                    ->placeholder('-'),
                TextEntry::make('icon')
                    ->placeholder('-'),
                TextEntry::make('sort_order')
                    ->numeric(),
                IconEntry::make('is_featured')
                    ->boolean(),
                IconEntry::make('is_active')
                    ->boolean(),
                IconEntry::make('show_when_empty')
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
                    ->visible(fn (ProductCategory $record): bool => $record->trashed()),
            ]);
    }
}
