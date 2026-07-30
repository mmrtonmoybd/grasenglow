<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Pages\Schemas;

use App\Enums\ContentStatus;
use App\Enums\PageTemplate;
use App\Filament\Forms\Components\PublicImageUpload as FileUpload;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

final class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                TextInput::make('navigation_label')
                    ->default(null),
                Select::make('page_template')
                    ->options(PageTemplate::class)
                    ->default('standard')
                    ->required(),
                Textarea::make('excerpt')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('body')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('hero_title')
                    ->default(null),
                TextInput::make('hero_subtitle')
                    ->default(null),
                Textarea::make('hero_description')
                    ->default(null)
                    ->columnSpanFull(),
                FileUpload::make('hero_image')
                    ->image(),
                TextInput::make('hero_image_alt')
                    ->requiredWith('hero_image')
                    ->maxLength(255),
                TextInput::make('primary_cta_label')
                    ->default(null),
                TextInput::make('primary_cta_url')
                   // ->url()
                    ->default(null),
                TextInput::make('secondary_cta_label')
                    ->default(null),
                TextInput::make('secondary_cta_url')
                   // ->url()
                    ->default(null),
                Select::make('status')
                    ->options(ContentStatus::class)
                    ->default('draft')
                    ->required(),
                DateTimePicker::make('published_at'),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_indexable')
                    ->required(),
                TextInput::make('canonical_url')
                  //  ->url()
                    ->default(null),
                TextInput::make('meta_title')
                    ->maxLength(70)
                    ->default(null),
                TextInput::make('meta_description')
                    ->maxLength(320)
                    ->default(null),
                Textarea::make('meta_keywords')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('open_graph_title')
                    ->default(null),
                TextInput::make('open_graph_description')
                    ->default(null),
                FileUpload::make('open_graph_image')
                    ->image(),
                TextInput::make('twitter_card_type')
                    ->required()
                    ->default('summary_large_image'),
                TextInput::make('schema_type')
                    ->default(null),
                TextInput::make('created_by')
                    ->numeric()
                    ->default(null),
                TextInput::make('updated_by')
                    ->numeric()
                    ->default(null),
            ]);
    }
}
