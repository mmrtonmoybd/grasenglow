<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\NewsletterSubscribers\Pages;

use App\Filament\Admin\Resources\NewsletterSubscribers\NewsletterSubscriberResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

final class ViewNewsletterSubscriber extends ViewRecord
{
    protected static string $resource = NewsletterSubscriberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
