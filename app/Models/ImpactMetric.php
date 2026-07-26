<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

final class ImpactMetric extends CmsModel
{
    /** @use HasFactory<\Database\Factories\ImpactMetricFactory> */
    use HasFactory;

    protected $fillable = [
        'title', 'numeric_value', 'display_value', 'unit', 'prefix', 'suffix', 'description',
        'icon', 'image', 'image_alt', 'sort_order', 'is_active', 'last_verified_at', 'created_by', 'updated_by',
    ];

    #[Scope]
    protected function active(Builder $query): void
    {
        $query->where('is_active', true);
    }

    protected function casts(): array
    {
        return [
            'numeric_value' => 'decimal:2',
            'is_active' => 'boolean',
            'last_verified_at' => 'date',
        ];
    }
}
