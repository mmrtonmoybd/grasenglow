<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ImpactStories\Schemas;

use App\Models\ImpactStory;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

final class ImpactStoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('relatedProject.title')
                    ->label('Related project')
                    ->placeholder('-'),
                TextEntry::make('title'),
                TextEntry::make('slug'),
                TextEntry::make('excerpt')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('body')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('beneficiary_type')
                    ->placeholder('-'),
                TextEntry::make('impact_date')
                    ->date()
                    ->placeholder('-'),
                ImageEntry::make('featured_image')
                    ->placeholder('-'),
                ImageEntry::make('featured_image_alt')
                    ->placeholder('-'),
                TextEntry::make('gallery')
                    ->placeholder('-')
                    ->columnSpanFull(),
                IconEntry::make('is_featured')
                    ->boolean(),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('published_at')
                    ->dateTime()
                    ->placeholder('-'),
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
                    ->visible(fn (ImpactStory $record): bool => $record->trashed()),
            ]);
    }
}
