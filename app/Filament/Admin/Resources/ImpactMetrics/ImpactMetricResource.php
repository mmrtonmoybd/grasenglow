<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ImpactMetrics;

use App\Filament\Admin\Resources\CmsResource;
use App\Filament\Admin\Resources\ImpactMetrics\Pages\CreateImpactMetric;
use App\Filament\Admin\Resources\ImpactMetrics\Pages\EditImpactMetric;
use App\Filament\Admin\Resources\ImpactMetrics\Pages\ListImpactMetrics;
use App\Filament\Admin\Resources\ImpactMetrics\Pages\ViewImpactMetric;
use App\Filament\Admin\Resources\ImpactMetrics\Schemas\ImpactMetricForm;
use App\Filament\Admin\Resources\ImpactMetrics\Schemas\ImpactMetricInfolist;
use App\Filament\Admin\Resources\ImpactMetrics\Tables\ImpactMetricsTable;
use App\Models\ImpactMetric;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

final class ImpactMetricResource extends CmsResource
{
    protected static ?string $model = ImpactMetric::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ImpactMetricForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ImpactMetricInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ImpactMetricsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListImpactMetrics::route('/'),
            'create' => CreateImpactMetric::route('/create'),
            'view' => ViewImpactMetric::route('/{record}'),
            'edit' => EditImpactMetric::route('/{record}/edit'),
        ];
    }
}
