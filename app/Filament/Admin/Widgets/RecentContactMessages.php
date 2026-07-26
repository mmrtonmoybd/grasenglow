<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Resources\ContactMessages\ContactMessageResource;
use App\Models\ContactMessage;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

final class RecentContactMessages extends TableWidget
{
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Recent contact messages')
            ->query(ContactMessage::query()->latest('submitted_at')->limit(8))
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('subject')->limit(45),
                TextColumn::make('status')->badge(),
                TextColumn::make('submitted_at')->since(),
            ])
            ->recordActions([
                ViewAction::make()->url(fn (ContactMessage $record): string => ContactMessageResource::getUrl('view', ['record' => $record])),
            ])
            ->paginated(false);
    }
}
