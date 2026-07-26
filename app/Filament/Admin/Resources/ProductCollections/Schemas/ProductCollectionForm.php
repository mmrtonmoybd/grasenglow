<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ProductCollections\Schemas;

use App\Enums\ContentStatus;
use App\Filament\Forms\Components\PublicImageUpload as FileUpload;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

final class ProductCollectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                TextInput::make('subtitle')
                    ->default(null),
                Textarea::make('short_description')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                FileUpload::make('cover_image')
                    ->image(),
                TextInput::make('cover_image_alt')
                    ->requiredWith('cover_image')
                    ->maxLength(255),
                FileUpload::make('banner_image')
                    ->image(),
                TextInput::make('banner_image_alt')
                    ->requiredWith('banner_image')
                    ->maxLength(255),
                Select::make('status')
                    ->options(ContentStatus::class)
                    ->default('draft')
                    ->required(),
                DateTimePicker::make('published_at'),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_featured')
                    ->required(),
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
                FileUpload::make('open_graph_image')
                    ->image(),
                TextInput::make('created_by')
                    ->numeric()
                    ->default(null),
                TextInput::make('updated_by')
                    ->numeric()
                    ->default(null),
            ]);
    }
}
