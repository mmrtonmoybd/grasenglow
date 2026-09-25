<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Posts\Schemas;

use App\Enums\ContentStatus;
use App\Filament\Forms\Components\PublicImageUpload as FileUpload;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

final class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('post_category_id')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),
                Select::make('author_id')
                    ->relationship('author', 'name')
                    ->default(null),
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
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
                FileUpload::make('featured_image')
                    ->image(),
                TextInput::make('featured_image_alt')
                    ->requiredWith('featured_image')
                    ->maxLength(255),
                Textarea::make('tags')
                    ->default(null)
                    ->columnSpanFull(),
                Select::make('status')
                    ->options(ContentStatus::class)
                    ->default('draft')
                    ->required(),
                DateTimePicker::make('published_at'),
                Toggle::make('is_featured')
                    ->required(),
                TextInput::make('reading_time')
                    ->numeric()
                    ->default(null),
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
