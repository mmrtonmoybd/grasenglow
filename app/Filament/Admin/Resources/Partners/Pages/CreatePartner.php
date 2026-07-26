<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Partners\Pages;

use App\Filament\Admin\Resources\Partners\PartnerResource;
use Filament\Resources\Pages\CreateRecord;

final class CreatePartner extends CreateRecord
{
    protected static string $resource = PartnerResource::class;
}
