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
                        '<img width="48" height="48" src="https://img.icons8.com/fluency/48/linkedin.png" alt="linkedin"/>' => 'LinkedIn',
                        '<img width="48" height="48" src="https://img.icons8.com/fluency/48/facebook.png" alt="facebook"/>' => 'Facebook',
                        '<img width="48" height="48" src="https://img.icons8.com/fluency/48/instagram.png" alt="instagram"/>' => 'Instagram',
                        '<img width="48" height="48" src="https://img.icons8.com/fluency/48/youtube.png" alt="youtube"/>' => 'YouTube',
                        '<img width="48" height="48" src="https://img.icons8.com/fluency/48/pinterest.png" alt="pinterest"/>' => 'Pinterest',
                        '<img width="48" height="48" src="https://img.icons8.com/fluency/48/tiktok.png" alt="tiktok"/>' => 'TikTok',
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
