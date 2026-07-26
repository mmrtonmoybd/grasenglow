<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ContactMessages\Pages;

use App\Filament\Admin\Resources\ContactMessages\ContactMessageResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateContactMessage extends CreateRecord
{
    protected static string $resource = ContactMessageResource::class;
}
