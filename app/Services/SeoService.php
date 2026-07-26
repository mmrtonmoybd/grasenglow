<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

final readonly class SeoService
{
    public function __construct(private SiteSettingsService $settings) {}

    /** @return array<string, mixed> */
    public function for(?Model $record = null, ?string $fallbackTitle = null, ?string $fallbackDescription = null): array
    {
        $settings = $this->settings->get();
        $title = $record?->getAttribute('meta_title')
            ?: $record?->getAttribute('title')
            ?: $record?->getAttribute('name')
            ?: $fallbackTitle
            ?: $settings->default_meta_title
            ?: $settings->site_name;
        $description = $record?->getAttribute('meta_description')
            ?: $record?->getAttribute('excerpt')
            ?: $record?->getAttribute('short_description')
            ?: $fallbackDescription
            ?: $settings->default_meta_description;
        $canonical = $record?->getAttribute('canonical_url') ?: url()->current();
        $image = $record?->getAttribute('open_graph_image')
            ?: $record?->getAttribute('featured_image')
            ?: $settings->default_open_graph_image;

        return [
            'title' => Str::limit(strip_tags((string) $title), 70, ''),
            'description' => Str::limit(strip_tags((string) $description), 320, ''),
            'canonical' => $canonical,
            'image' => $image,
            'indexable' => $record?->getAttribute('is_indexable') ?? $settings->robots_index_enabled,
            'site' => $settings,
        ];
    }
}
