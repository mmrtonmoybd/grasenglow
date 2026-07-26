<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Partners\Pages;

use App\Filament\Admin\Resources\Partners\PartnerResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

final class EditPartner extends EditRecord
{
    protected static string $resource = PartnerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
