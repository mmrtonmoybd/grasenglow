<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Partners\Schemas;

use App\Filament\Forms\Components\PublicImageUpload;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

final class PartnerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('partner_type')
                    ->default(null),
                PublicImageUpload::make('logo'),
                TextInput::make('logo_alt')
                    ->requiredWith('logo')
                    ->maxLength(255),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('website')
                    ->url()
                    ->default(null),
                TextInput::make('location')
                    ->default(null),
                DatePicker::make('partnership_start_date'),
                Toggle::make('is_featured')
                    ->required(),
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
