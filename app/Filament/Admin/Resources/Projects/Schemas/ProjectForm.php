<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Projects\Schemas;

use App\Enums\ContentStatus;
use App\Enums\ProjectStatus;
use App\Filament\Forms\Components\PublicImageUpload as FileUpload;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

final class ProjectForm
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
                Textarea::make('short_description')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('objective')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('methodology')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('results')
                    ->default(null)
                    ->columnSpanFull(),
                DatePicker::make('start_date'),
                DatePicker::make('end_date'),
                Select::make('status')
                    ->options(ProjectStatus::class)
                    ->default('planned')
                    ->required(),
                FileUpload::make('featured_image')
                    ->image(),
                TextInput::make('featured_image_alt')
                    ->requiredWith('featured_image')
                    ->maxLength(255),
                Repeater::make('gallery')
                    ->schema([
                        FileUpload::make('image')->required(),
                        TextInput::make('alt_text')->required()->maxLength(255),
                        TextInput::make('caption')->maxLength(255),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Textarea::make('partners')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('external_url')
                    ->url()
                    ->default(null),
                TextInput::make('document')
                    ->default(null),
                Toggle::make('is_featured')
                    ->required(),
                DateTimePicker::make('published_at'),
                Select::make('publication_status')
                    ->options(ContentStatus::class)
                    ->default('draft')
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
