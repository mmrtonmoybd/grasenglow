<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\NewsletterSubscribers\Pages;

use App\Filament\Admin\Resources\NewsletterSubscribers\NewsletterSubscriberResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

final class EditNewsletterSubscriber extends EditRecord
{
    protected static string $resource = NewsletterSubscriberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
