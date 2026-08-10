<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\HeroSlides\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

final class HeroSlidesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->disk('public')
                    ->visibility('public')
                    ->square(),
                TextColumn::make('internal_name')->searchable()->sortable(),
                // TextColumn::make('heading')->searchable(),
                TextColumn::make('duration_seconds')->suffix(' sec')->sortable(),
                TextColumn::make('sort_order')->sortable(),
                IconColumn::make('is_enabled')->boolean(),
                TextColumn::make('license')->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_enabled'),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
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
