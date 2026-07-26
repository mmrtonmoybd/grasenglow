<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ImpactMetrics\Schemas;

use App\Filament\Forms\Components\PublicImageUpload as FileUpload;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

final class ImpactMetricForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('numeric_value')
                    ->numeric()
                    ->default(null),
                TextInput::make('display_value')
                    ->required(),
                TextInput::make('unit')
                    ->default(null),
                TextInput::make('prefix')
                    ->default(null),
                TextInput::make('suffix')
                    ->default(null),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                Select::make('icon')
                    ->options([
                        'recycle' => 'Recycle',
                        'quilt' => 'Quilt',
                        'bag' => 'Bag',
                        'shop' => 'Shop',
                        'people' => 'People',
                        'paw' => 'Paw',
                        'heart' => 'Heart',
                    ]),
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
                DatePicker::make('last_verified_at'),
                TextInput::make('created_by')
                    ->numeric()
                    ->default(null),
                TextInput::make('updated_by')
                    ->numeric()
                    ->default(null),
            ]);
    }
}
