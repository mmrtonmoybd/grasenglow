<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ImpactMetrics\Pages;

use App\Filament\Admin\Resources\ImpactMetrics\ImpactMetricResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

final class ViewImpactMetric extends ViewRecord
{
    protected static string $resource = ImpactMetricResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
