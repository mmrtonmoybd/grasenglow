<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

final class Testimonial extends CmsModel
{
    /** @use HasFactory<\Database\Factories\TestimonialFactory> */
    use HasFactory;

    protected $fillable = [
        'name', 'role', 'organization', 'quote', 'image', 'image_alt', 'rating', 'sort_order',
        'is_featured', 'is_active', 'consent_confirmed', 'created_by', 'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'consent_confirmed' => 'boolean',
        ];
    }
}
