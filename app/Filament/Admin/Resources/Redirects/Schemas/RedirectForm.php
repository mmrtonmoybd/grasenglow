<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Redirects\Schemas;

use App\Rules\SafeUrl;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

final class RedirectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('old_path')
                    ->startsWith('/')
                    ->maxLength(255)
                    ->required(),
                TextInput::make('destination_url')
                    ->rule(new SafeUrl)
                    ->startsWith('/')
                    ->maxLength(2048)
                    ->required(),
                Select::make('status_code')
                    ->options([301 => '301 Permanent', 302 => '302 Temporary', 307 => '307 Temporary', 308 => '308 Permanent'])
                    ->required()
                    ->default(301),
                Toggle::make('is_active')
                    ->required(),
                TextInput::make('hit_count')
                    ->disabled()
                    ->dehydrated(false)
                    ->numeric()
                    ->default(0),
                TextInput::make('created_by')
                    ->numeric()
                    ->default(null),
                TextInput::make('updated_by')
                    ->numeric()
                    ->default(null),
            ]);
    }
}
