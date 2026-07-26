<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\PageSections\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class PageSectionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('page.title')
                    ->searchable(),
                TextColumn::make('section_type')
                    ->badge()
                    ->searchable(),
                TextColumn::make('internal_name')
                    ->searchable(),
                TextColumn::make('eyebrow')
                    ->searchable(),
                TextColumn::make('heading')
                    ->searchable(),
                TextColumn::make('subheading')
                    ->searchable(),
                ImageColumn::make('image'),
                ImageColumn::make('mobile_image'),
                ImageColumn::make('image_alt'),
                ImageColumn::make('background_image'),
                ImageColumn::make('background_image_alt'),
                TextColumn::make('primary_cta_label')
                    ->searchable(),
                TextColumn::make('primary_cta_url')
                    ->searchable(),
                TextColumn::make('secondary_cta_label')
                    ->searchable(),
                TextColumn::make('secondary_cta_url')
                    ->searchable(),
                TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_enabled')
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
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
