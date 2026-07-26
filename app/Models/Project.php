<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ContentStatus;
use App\Enums\ProjectStatus;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Project extends CmsModel
{
    /** @use HasFactory<\Database\Factories\ProjectFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'short_description', 'description', 'objective', 'methodology', 'results',
        'start_date', 'end_date', 'status', 'featured_image', 'featured_image_alt', 'gallery',
        'partners', 'external_url', 'document', 'is_featured', 'published_at', 'publication_status',
        'meta_title', 'meta_description', 'meta_keywords', 'canonical_url', 'open_graph_image',
        'created_by', 'updated_by',
    ];

    #[Scope]
    protected function published(Builder $query): void
    {
        $query->whereIn('publication_status', [ContentStatus::Published, ContentStatus::Scheduled])
            ->where(function (Builder $query): void {
                $query
                    ->where(fn (Builder $query): Builder => $query->where('publication_status', ContentStatus::Published)->whereNull('published_at'))
                    ->orWhere('published_at', '<=', now());
            });
    }

    protected function casts(): array
    {
        return [
            'status' => ProjectStatus::class,
            'publication_status' => ContentStatus::class,
            'gallery' => 'array',
            'start_date' => 'date',
            'end_date' => 'date',
            'published_at' => 'datetime',
            'is_featured' => 'boolean',
        ];
    }
}
