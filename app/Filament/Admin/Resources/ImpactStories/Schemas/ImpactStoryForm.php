<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ImpactStories\Schemas;

use App\Enums\ContentStatus;
use App\Filament\Forms\Components\PublicImageUpload as FileUpload;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

final class ImpactStoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('related_project_id')
                    ->relationship('relatedProject', 'title')
                    ->default(null),
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Textarea::make('excerpt')
                    ->default(null)
                    ->columnSpanFull(),
                MarkdownEditor::make('body')
                    ->default(null)
                    ->toolbarButtons([
                        ['bold', 'italic', 'strike', 'link'],
                        ['heading'],
                        ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
                        ['table'],
                        ['undo', 'redo'],
                    ])
                    ->helperText('Markdown supported: **bold**, _italic_, # headings, - lists, [links](https://example.com).')
                    ->columnSpanFull(),
                TextInput::make('beneficiary_type')
                    ->default(null),
                DatePicker::make('impact_date'),
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
                Toggle::make('is_featured')
                    ->required(),
                Select::make('status')
                    ->options(ContentStatus::class)
                    ->default('draft')
                    ->required(),
                DateTimePicker::make('published_at'),
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
