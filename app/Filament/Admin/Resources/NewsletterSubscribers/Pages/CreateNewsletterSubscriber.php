<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\NewsletterSubscribers\Pages;

use App\Filament\Admin\Resources\NewsletterSubscribers\NewsletterSubscriberResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateNewsletterSubscriber extends CreateRecord
{
    protected static string $resource = NewsletterSubscriberResource::class;
}
