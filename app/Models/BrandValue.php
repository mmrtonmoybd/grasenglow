<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

final class BrandValue extends CmsModel
{
    /** @use HasFactory<\Database\Factories\BrandValueFactory> */
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'icon', 'image', 'image_alt', 'sort_order', 'is_active', 'created_by', 'updated_by',
    ];

    #[Scope]
    protected function active(Builder $query): void
    {
        $query->where('is_active', true);
    }

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }
}
