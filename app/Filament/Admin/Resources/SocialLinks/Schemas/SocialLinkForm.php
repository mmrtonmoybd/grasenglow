<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\SocialLinks\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

final class SocialLinkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('platform')
                    ->options([
                        'linkedin' => 'LinkedIn',
                        'facebook' => 'Facebook',
                        'instagram' => 'Instagram',
                        'youtube' => 'YouTube',
                        'pinterest' => 'Pinterest',
                        'tiktok' => 'TikTok',
                    ])
                    ->required(),
                TextInput::make('label')
                    ->required(),
                TextInput::make('url')
                    ->url()
                    ->required(),
                Select::make('icon')
                    ->options([
                        'linkedin' => 'LinkedIn',
                        'facebook' => 'Facebook',
                        'instagram' => 'Instagram',
                        'youtube' => 'YouTube',
                        'pinterest' => 'Pinterest',
                        'tiktok' => 'TikTok',
                    ]),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->required(),
                Toggle::make('open_in_new_tab')
                    ->required(),
            ]);
    }
}
