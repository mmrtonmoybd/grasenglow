<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ImpactMetrics\Pages;

use App\Filament\Admin\Resources\ImpactMetrics\ImpactMetricResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

final class EditImpactMetric extends EditRecord
{
    protected static string $resource = ImpactMetricResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
