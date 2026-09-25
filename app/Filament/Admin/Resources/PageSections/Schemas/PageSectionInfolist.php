<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\PageSections\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

final class PageSectionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('page.title')
                    ->label('Page'),
                TextEntry::make('section_type')
                    ->badge(),
                TextEntry::make('internal_name'),
                TextEntry::make('eyebrow')
                    ->placeholder('-'),
                TextEntry::make('heading')
                    ->placeholder('-'),
                TextEntry::make('subheading')
                    ->placeholder('-'),
                TextEntry::make('body')
                    ->markdown()
                    ->placeholder('-')
                    ->columnSpanFull(),
                ImageEntry::make('image')
                    ->placeholder('-'),
                ImageEntry::make('mobile_image')
                    ->placeholder('-'),
                ImageEntry::make('image_alt')
                    ->placeholder('-'),
                ImageEntry::make('background_image')
                    ->placeholder('-'),
                ImageEntry::make('background_image_alt')
                    ->placeholder('-'),
                TextEntry::make('primary_cta_label')
                    ->placeholder('-'),
                TextEntry::make('primary_cta_url')
                    ->placeholder('-'),
                TextEntry::make('secondary_cta_label')
                    ->placeholder('-'),
                TextEntry::make('secondary_cta_url')
                    ->placeholder('-'),
                TextEntry::make('settings')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('sort_order')
                    ->numeric(),
                IconEntry::make('is_enabled')
                    ->boolean(),
                TextEntry::make('created_by')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('updated_by')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
