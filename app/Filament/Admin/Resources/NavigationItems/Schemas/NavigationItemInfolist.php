<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\NavigationItems\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

final class NavigationItemInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('navigation_menu_id')
                    ->numeric(),
                TextEntry::make('parent.id')
                    ->label('Parent')
                    ->placeholder('-'),
                TextEntry::make('label'),
                TextEntry::make('link_type')
                    ->badge(),
                TextEntry::make('link_value'),
                TextEntry::make('icon')
                    ->placeholder('-'),
                TextEntry::make('sort_order')
                    ->numeric(),
                IconEntry::make('is_active')
                    ->boolean(),
                IconEntry::make('open_in_new_tab')
                    ->boolean(),
                IconEntry::make('nofollow')
                    ->boolean(),
                IconEntry::make('show_on_desktop')
                    ->boolean(),
                IconEntry::make('show_on_mobile')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
