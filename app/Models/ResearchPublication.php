<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ContentStatus;
use App\Enums\ResearchStatus;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

final class ResearchPublication extends CmsModel
{
    /** @use HasFactory<\Database\Factories\ResearchPublicationFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'abstract', 'authors', 'publication_name', 'publication_date', 'research_status',
        'document', 'external_url', 'featured_image', 'featured_image_alt', 'keywords', 'publication_status',
        'published_at', 'meta_title', 'meta_description', 'canonical_url', 'open_graph_image',
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
            'research_status' => ResearchStatus::class,
            'publication_status' => ContentStatus::class,
            'publication_date' => 'date',
            'published_at' => 'datetime',
        ];
    }
}
