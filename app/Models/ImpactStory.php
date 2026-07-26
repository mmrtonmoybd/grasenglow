<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ContentStatus;
use App\Models\Concerns\HasPublicationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class ImpactStory extends CmsModel
{
    /** @use HasFactory<\Database\Factories\ImpactStoryFactory> */
    use HasFactory, HasPublicationStatus, SoftDeletes;

    protected $fillable = [
        'related_project_id', 'title', 'slug', 'excerpt', 'body', 'beneficiary_type', 'impact_date',
        'featured_image', 'featured_image_alt', 'gallery', 'is_featured', 'status', 'published_at',
        'meta_title', 'meta_description', 'meta_keywords', 'canonical_url', 'open_graph_image',
        'created_by', 'updated_by',
    ];

    public function relatedProject(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'related_project_id');
    }

    protected function casts(): array
    {
        return [
            'status' => ContentStatus::class,
            'impact_date' => 'date',
            'published_at' => 'datetime',
            'gallery' => 'array',
            'is_featured' => 'boolean',
        ];
    }
}
