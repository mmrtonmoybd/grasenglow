<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ResearchPublications\Schemas;

use App\Models\ResearchPublication;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

final class ResearchPublicationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title'),
                TextEntry::make('slug'),
                TextEntry::make('abstract')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('authors')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('publication_name')
                    ->placeholder('-'),
                TextEntry::make('publication_date')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('research_status')
                    ->badge(),
                TextEntry::make('document')
                    ->placeholder('-'),
                TextEntry::make('external_url')
                    ->placeholder('-'),
                ImageEntry::make('featured_image')
                    ->placeholder('-'),
                ImageEntry::make('featured_image_alt')
                    ->placeholder('-'),
                TextEntry::make('keywords')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('publication_status')
                    ->badge(),
                TextEntry::make('published_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('meta_title')
                    ->placeholder('-'),
                TextEntry::make('meta_description')
                    ->placeholder('-'),
                TextEntry::make('canonical_url')
                    ->placeholder('-'),
                ImageEntry::make('open_graph_image')
                    ->placeholder('-'),
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
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (ResearchPublication $record): bool => $record->trashed()),
            ]);
    }
}
