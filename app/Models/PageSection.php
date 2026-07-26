<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\SectionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class PageSection extends CmsModel
{
    /** @use HasFactory<\Database\Factories\PageSectionFactory> */
    use HasFactory;

    protected $fillable = [
        'page_id', 'section_type', 'internal_name', 'eyebrow', 'heading', 'subheading', 'body',
        'image', 'mobile_image', 'image_alt', 'background_image', 'background_image_alt',
        'primary_cta_label', 'primary_cta_url', 'secondary_cta_label', 'secondary_cta_url',
        'settings', 'sort_order', 'is_enabled', 'created_by', 'updated_by',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    /** @param array<string, mixed>|string|null $value */
    public function setSettingsAttribute(array|string|null $value): void
    {
        $settings = is_string($value) ? json_decode($value, true) : $value;
        $allowedKeys = [
            'layout', 'alignment', 'columns', 'overlay_text', 'thank_you_text',
            'show_description', 'limit', 'background_style', 'image_position',
        ];

        $this->attributes['settings'] = json_encode(
            array_intersect_key(is_array($settings) ? $settings : [], array_flip($allowedKeys)),
        );
    }

    protected function casts(): array
    {
        return [
            'section_type' => SectionType::class,
            'settings' => 'array',
            'is_enabled' => 'boolean',
        ];
    }
}
