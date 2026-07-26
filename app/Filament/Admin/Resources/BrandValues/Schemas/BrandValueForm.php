<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\BrandValues\Schemas;

use App\Filament\Forms\Components\PublicImageUpload as FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

final class BrandValueForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                Select::make('icon')
                    ->options(['leaf' => 'Leaf', 'hand' => 'Handmade', 'people' => 'People', 'heart' => 'Heart']),
                FileUpload::make('image')
                    ->image(),
                TextInput::make('image_alt')
                    ->maxLength(255),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
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
