<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ContentStatus;
use App\Enums\PageTemplate;
use App\Models\Concerns\HasPublicationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Page extends CmsModel
{
    /** @use HasFactory<\Database\Factories\PageFactory> */
    use HasFactory, HasPublicationStatus, SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'navigation_label', 'page_template', 'excerpt', 'body', 'hero_title',
        'hero_subtitle', 'hero_description', 'hero_image', 'hero_image_alt', 'primary_cta_label',
        'primary_cta_url', 'secondary_cta_label', 'secondary_cta_url', 'status', 'published_at',
        'sort_order', 'is_indexable', 'canonical_url', 'meta_title', 'meta_description', 'meta_keywords',
        'open_graph_title', 'open_graph_description', 'open_graph_image', 'twitter_card_type',
        'schema_type', 'created_by', 'updated_by',
    ];

    public function sections(): HasMany
    {
        return $this->hasMany(PageSection::class)->orderBy('sort_order');
    }

    protected function casts(): array
    {
        return [
            'page_template' => PageTemplate::class,
            'status' => ContentStatus::class,
            'published_at' => 'datetime',
            'is_indexable' => 'boolean',
        ];
    }
}
