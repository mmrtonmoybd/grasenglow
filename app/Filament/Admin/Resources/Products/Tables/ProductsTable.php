<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Products\Tables;

use App\Enums\ContentStatus;
use App\Enums\ProductAvailabilityStatus;
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
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

final class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('category.name')
                    ->label('Category')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('slug')
                    ->searchable(),
                TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable(),
                TextColumn::make('dimensions')
                    ->searchable(),
                TextColumn::make('weight')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('color_description')
                    ->searchable(),
                TextColumn::make('price')
                    ->money()
                    ->sortable(),
                TextColumn::make('compare_price')
                    ->money()
                    ->sortable(),
                TextColumn::make('currency')
                    ->searchable(),
                TextColumn::make('availability_status')
                    ->badge()
                    ->searchable(),
                TextColumn::make('stock_quantity')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('made_to_order')
                    ->boolean(),
                TextColumn::make('lead_time')
                    ->searchable(),
                IconColumn::make('inquiry_enabled')
                    ->boolean(),
                TextColumn::make('inquiry_button_label')
                    ->searchable(),
                TextColumn::make('inquiry_url')
                    ->searchable(),
                ImageColumn::make('featured_image'),
                TextColumn::make('featured_image_alt')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('status')
                    ->badge()
                    ->searchable(),
                TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(),
                IconColumn::make('is_featured')
                    ->boolean(),
                IconColumn::make('is_new')
                    ->boolean(),
                TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('meta_title')
                    ->searchable(),
                TextColumn::make('meta_description')
                    ->searchable(),
                TextColumn::make('canonical_url')
                    ->searchable(),
                TextColumn::make('open_graph_title')
                    ->searchable(),
                TextColumn::make('open_graph_description')
                    ->searchable(),
                ImageColumn::make('open_graph_image'),
                IconColumn::make('is_indexable')
                    ->boolean(),
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
                SelectFilter::make('product_category_id')
                    ->label('Category')
                    ->relationship('category', 'name'),
                SelectFilter::make('availability_status')->options(ProductAvailabilityStatus::class),
                TernaryFilter::make('is_featured')->label('Featured'),
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
