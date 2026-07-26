<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

final class Partner extends CmsModel
{
    /** @use HasFactory<\Database\Factories\PartnerFactory> */
    use HasFactory;

    protected $fillable = [
        'name', 'partner_type', 'logo', 'logo_alt', 'description', 'website', 'location',
        'partnership_start_date', 'is_featured', 'sort_order', 'is_active', 'created_by', 'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'partnership_start_date' => 'date',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ];
    }
}
