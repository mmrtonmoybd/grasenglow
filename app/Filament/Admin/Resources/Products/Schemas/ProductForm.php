<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Products\Schemas;

use App\Enums\ContentStatus;
use App\Enums\ProductAvailabilityStatus;
use App\Filament\Forms\Components\PublicImageUpload as FileUpload;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

final class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('product_category_id')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->columnSpanFull(),
                Select::make('collections')
                    ->relationship('collections', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->columnSpanFull(),
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                TextInput::make('sku')
                    ->label('SKU')
                    ->default(null),
                Textarea::make('short_description')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('story')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('materials')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('craftsmanship_details')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('sustainability_details')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('animal_support_details')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('care_instructions')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('dimensions')
                    ->default(null),
                TextInput::make('weight')
                    ->numeric()
                    ->default(null),
                TextInput::make('color_description')
                    ->default(null),
                TextInput::make('price')
                    ->numeric()
                    ->default(null)
                    ->prefix('$'),
                TextInput::make('compare_price')
                    ->numeric()
                    ->default(null)
                    ->prefix('$'),
                TextInput::make('currency')
                    ->length(3)
                    ->default(null),
                Select::make('availability_status')
                    ->options(ProductAvailabilityStatus::class)
                    ->default('inquiry_only')
                    ->required(),
                TextInput::make('stock_quantity')
                    ->numeric()
                    ->default(null),
                Toggle::make('made_to_order')
                    ->required(),
                TextInput::make('lead_time')
                    ->default(null),
                Toggle::make('inquiry_enabled')
                    ->required(),
                TextInput::make('inquiry_button_label')
                    ->default(null),
                TextInput::make('inquiry_url')
                    ->url()
                    ->default(null),
                FileUpload::make('featured_image')
                    ->image(),
                TextInput::make('featured_image_alt')
                    ->requiredWith('featured_image')
                    ->maxLength(255),
                Select::make('status')
                    ->options(ContentStatus::class)
                    ->default('draft')
                    ->required(),
                DateTimePicker::make('published_at'),
                Toggle::make('is_featured')
                    ->required(),
                Toggle::make('is_new')
                    ->required(),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('meta_title')
                    ->default(null),
                TextInput::make('meta_description')
                    ->default(null),
                Textarea::make('meta_keywords')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('canonical_url')
                    ->url()
                    ->default(null),
                TextInput::make('open_graph_title')
                    ->default(null),
                TextInput::make('open_graph_description')
                    ->default(null),
                FileUpload::make('open_graph_image')
                    ->image(),
                Toggle::make('is_indexable')
                    ->required(),
                TextInput::make('created_by')
                    ->numeric()
                    ->default(null),
                TextInput::make('updated_by')
                    ->numeric()
                    ->default(null),
            ]);
    }
}
