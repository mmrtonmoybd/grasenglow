<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ProductImages\Schemas;

use App\Filament\Forms\Components\PublicImageUpload as FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

final class ProductImageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('product_id')
                    ->relationship('product', 'name')
                    ->required(),
                FileUpload::make('image')
                    ->image()
                    ->required(),
                TextInput::make('alt_text')
                    ->required(),
                TextInput::make('caption')
                    ->default(null),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_primary')
                    ->required(),
            ]);
    }
}
