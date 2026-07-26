<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\NavigationItems\Schemas;

use App\Enums\LinkType;
use App\Rules\SafeUrl;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

final class NavigationItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('navigation_menu_id')
                    ->relationship('menu', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->columnSpanFull(),
                Select::make('parent_id')
                    ->relationship('parent', 'label')
                    ->searchable()
                    ->preload()
                    ->default(null),
                TextInput::make('label')
                    ->required(),
                Select::make('link_type')
                    ->options(LinkType::class)
                    ->default('internal')
                    ->required(),
                TextInput::make('link_value')
                    ->rule(new SafeUrl)
                    ->maxLength(2048)
                    ->required(),
                TextInput::make('icon')
                    ->default(null),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->required(),
                Toggle::make('open_in_new_tab')
                    ->required(),
                Toggle::make('nofollow')
                    ->required(),
                Toggle::make('show_on_desktop')
                    ->required(),
                Toggle::make('show_on_mobile')
                    ->required(),
            ]);
    }
}
