<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Projects\Schemas;

use App\Models\Project;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

final class ProjectInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title'),
                TextEntry::make('slug'),
                TextEntry::make('short_description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('objective')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('methodology')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('results')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('start_date')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('end_date')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('status')
                    ->badge(),
                ImageEntry::make('featured_image')
                    ->placeholder('-'),
                ImageEntry::make('featured_image_alt')
                    ->placeholder('-'),
                TextEntry::make('gallery')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('partners')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('external_url')
                    ->placeholder('-'),
                TextEntry::make('document')
                    ->placeholder('-'),
                IconEntry::make('is_featured')
                    ->boolean(),
                TextEntry::make('published_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('publication_status')
                    ->badge(),
                TextEntry::make('meta_title')
                    ->placeholder('-'),
                TextEntry::make('meta_description')
                    ->placeholder('-'),
                TextEntry::make('meta_keywords')
                    ->placeholder('-')
                    ->columnSpanFull(),
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
                    ->visible(fn (Project $record): bool => $record->trashed()),
            ]);
    }
}
