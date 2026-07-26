<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Pages\Tables;

use App\Enums\ContentStatus;
use App\Enums\PageTemplate;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

final class PagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('slug')
                    ->searchable(),
                TextColumn::make('navigation_label')
                    ->searchable(),
                TextColumn::make('page_template')
                    ->badge()
                    ->searchable(),
                TextColumn::make('hero_title')
                    ->searchable(),
                TextColumn::make('hero_subtitle')
                    ->searchable(),
                ImageColumn::make('hero_image'),
                TextColumn::make('hero_image_alt')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('primary_cta_label')
                    ->searchable(),
                TextColumn::make('primary_cta_url')
                    ->searchable(),
                TextColumn::make('secondary_cta_label')
                    ->searchable(),
                TextColumn::make('secondary_cta_url')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->searchable(),
                TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_indexable')
                    ->boolean(),
                TextColumn::make('canonical_url')
                    ->searchable(),
                TextColumn::make('meta_title')
                    ->searchable(),
                TextColumn::make('meta_description')
                    ->searchable(),
                TextColumn::make('open_graph_title')
                    ->searchable(),
                TextColumn::make('open_graph_description')
                    ->searchable(),
                ImageColumn::make('open_graph_image'),
                TextColumn::make('twitter_card_type')
                    ->searchable(),
                TextColumn::make('schema_type')
                    ->searchable(),
                TextColumn::make('created_by')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('updated_by')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')->options(ContentStatus::class),
                SelectFilter::make('page_template')->options(PageTemplate::class),
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('publish')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each->update([
                            'status' => ContentStatus::Published,
                            'published_at' => now(),
                        ]))
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('unpublish')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each->update([
                            'status' => ContentStatus::Draft,
                            'published_at' => null,
                        ]))
                        ->deselectRecordsAfterCompletion(),
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
