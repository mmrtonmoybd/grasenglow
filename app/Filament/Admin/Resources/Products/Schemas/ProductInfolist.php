<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Products\Schemas;

use App\Models\Product;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

final class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('product_category_id')
                    ->numeric(),
                TextEntry::make('name'),
                TextEntry::make('slug'),
                TextEntry::make('sku')
                    ->label('SKU')
                    ->placeholder('-'),
                TextEntry::make('short_description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('story')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('materials')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('craftsmanship_details')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('sustainability_details')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('animal_support_details')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('care_instructions')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('dimensions')
                    ->placeholder('-'),
                TextEntry::make('weight')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('color_description')
                    ->placeholder('-'),
                TextEntry::make('price')
                    ->money()
                    ->placeholder('-'),
                TextEntry::make('compare_price')
                    ->money()
                    ->placeholder('-'),
                TextEntry::make('currency')
                    ->placeholder('-'),
                TextEntry::make('availability_status')
                    ->badge(),
                TextEntry::make('stock_quantity')
                    ->numeric()
                    ->placeholder('-'),
                IconEntry::make('made_to_order')
                    ->boolean(),
                TextEntry::make('lead_time')
                    ->placeholder('-'),
                IconEntry::make('inquiry_enabled')
                    ->boolean(),
                TextEntry::make('inquiry_button_label')
                    ->placeholder('-'),
                TextEntry::make('inquiry_url')
                    ->placeholder('-'),
                ImageEntry::make('featured_image')
                    ->placeholder('-'),
                ImageEntry::make('featured_image_alt')
                    ->placeholder('-'),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('published_at')
                    ->dateTime()
                    ->placeholder('-'),
                IconEntry::make('is_featured')
                    ->boolean(),
                IconEntry::make('is_new')
                    ->boolean(),
                TextEntry::make('sort_order')
                    ->numeric(),
                TextEntry::make('meta_title')
                    ->placeholder('-'),
                TextEntry::make('meta_description')
                    ->placeholder('-'),
                TextEntry::make('meta_keywords')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('canonical_url')
                    ->placeholder('-'),
                TextEntry::make('open_graph_title')
                    ->placeholder('-'),
                TextEntry::make('open_graph_description')
                    ->placeholder('-'),
                ImageEntry::make('open_graph_image')
                    ->placeholder('-'),
                IconEntry::make('is_indexable')
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
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Product $record): bool => $record->trashed()),
            ]);
    }
}
