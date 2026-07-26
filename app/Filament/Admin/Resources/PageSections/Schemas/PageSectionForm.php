<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\PageSections\Schemas;

use App\Enums\SectionType;
use App\Filament\Forms\Components\PublicImageUpload as FileUpload;
use App\Rules\SafeUrl;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

final class PageSectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('page_id')
                    ->relationship('page', 'title')
                    ->required(),
                Select::make('section_type')
                    ->options(SectionType::class)
                    ->required(),
                TextInput::make('internal_name')
                    ->required(),
                TextInput::make('eyebrow')
                    ->default(null),
                TextInput::make('heading')
                    ->default(null),
                TextInput::make('subheading')
                    ->default(null),
                Textarea::make('body')
                    ->default(null)
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->image(),
                FileUpload::make('mobile_image')
                    ->image(),
                TextInput::make('image_alt')
                    ->requiredWith('image')
                    ->maxLength(255),
                FileUpload::make('background_image')
                    ->image(),
                TextInput::make('background_image_alt')
                    ->requiredWith('background_image')
                    ->maxLength(255),
                TextInput::make('primary_cta_label')
                    ->default(null),
                TextInput::make('primary_cta_url')
                    ->rules([new SafeUrl])
                    ->default(null),
                TextInput::make('secondary_cta_label')
                    ->default(null),
                TextInput::make('secondary_cta_url')
                    ->rules([new SafeUrl])
                    ->default(null),
                KeyValue::make('settings')
                    ->keyLabel('Approved setting')
                    ->valueLabel('Value')
                    ->helperText('Only supported presentation keys are retained.')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_enabled')
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
