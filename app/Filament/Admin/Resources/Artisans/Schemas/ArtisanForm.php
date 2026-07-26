<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Artisans\Schemas;

use App\Filament\Forms\Components\PublicImageUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

final class ArtisanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('display_name')
                    ->default(null),
                TextInput::make('role')
                    ->default(null),
                Textarea::make('biography')
                    ->default(null)
                    ->columnSpanFull(),
                PublicImageUpload::make('photograph'),
                TextInput::make('photograph_alt')
                    ->requiredWith('photograph')
                    ->maxLength(255),
                Textarea::make('quote')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_featured')
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
                Toggle::make('consent_confirmed')
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
