<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ImpactMetrics\Pages;

use App\Filament\Admin\Resources\ImpactMetrics\ImpactMetricResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

final class ListImpactMetrics extends ListRecords
{
    protected static string $resource = ImpactMetricResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
