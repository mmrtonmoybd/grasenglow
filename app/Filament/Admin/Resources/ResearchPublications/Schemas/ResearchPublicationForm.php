<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ResearchPublications\Schemas;

use App\Enums\ContentStatus;
use App\Enums\ResearchStatus;
use App\Filament\Forms\Components\PublicImageUpload as FileUpload;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

final class ResearchPublicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Textarea::make('abstract')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('authors')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('publication_name')
                    ->default(null),
                DatePicker::make('publication_date'),
                Select::make('research_status')
                    ->options(ResearchStatus::class)
                    ->default('ongoing')
                    ->required(),
                TextInput::make('document')
                    ->default(null),
                TextInput::make('external_url')
                    ->url()
                    ->default(null),
                FileUpload::make('featured_image')
                    ->image(),
                TextInput::make('featured_image_alt')
                    ->requiredWith('featured_image')
                    ->maxLength(255),
                Textarea::make('keywords')
                    ->default(null)
                    ->columnSpanFull(),
                Select::make('publication_status')
                    ->options(ContentStatus::class)
                    ->default('draft')
                    ->required(),
                DateTimePicker::make('published_at'),
                TextInput::make('meta_title')
                    ->default(null),
                TextInput::make('meta_description')
                    ->default(null),
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
