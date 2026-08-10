<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

final class HeroSlide extends CmsModel
{
    /** @use HasFactory<\Database\Factories\HeroSlideFactory> */
    use HasFactory;

    protected $fillable = [
        'internal_name', 'eyebrow', 'heading', 'subheading', 'body', 'feature_items', 'closing_text', 'image', 'mobile_image',
        'image_alt', 'primary_cta_label', 'primary_cta_url', 'secondary_cta_label',
        'secondary_cta_url', 'duration_seconds', 'sort_order', 'is_enabled', 'source_url',
        'license', 'attribution', 'created_by', 'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'feature_items' => 'array',
            'duration_seconds' => 'integer',
            'sort_order' => 'integer',
            'is_enabled' => 'boolean',
        ];
    }
}
