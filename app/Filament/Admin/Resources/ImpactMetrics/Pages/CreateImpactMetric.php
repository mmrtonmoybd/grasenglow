<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ImpactMetrics\Pages;

use App\Filament\Admin\Resources\ImpactMetrics\ImpactMetricResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateImpactMetric extends CreateRecord
{
    protected static string $resource = ImpactMetricResource::class;
}
