<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Faqs\Pages;

use App\Filament\Admin\Resources\Faqs\FaqResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

final class ViewFaq extends ViewRecord
{
    protected static string $resource = FaqResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
