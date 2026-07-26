<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Testimonials\Schemas;

use App\Filament\Forms\Components\PublicImageUpload as FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

final class TestimonialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('role')
                    ->default(null),
                TextInput::make('organization')
                    ->default(null),
                Textarea::make('quote')
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->image(),
                TextInput::make('image_alt')
                    ->requiredWith('image')
                    ->maxLength(255),
                TextInput::make('rating')
                    ->numeric()
                    ->default(null),
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
