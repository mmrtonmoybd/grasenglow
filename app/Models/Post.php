<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ContentStatus;
use App\Models\Concerns\HasPublicationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Post extends CmsModel
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory, HasPublicationStatus, SoftDeletes;

    protected $fillable = [
        'post_category_id', 'author_id', 'title', 'slug', 'excerpt', 'body', 'featured_image',
        'featured_image_alt', 'tags', 'status', 'published_at', 'is_featured', 'reading_time',
        'meta_title', 'meta_description', 'meta_keywords', 'canonical_url', 'open_graph_title',
        'open_graph_description', 'open_graph_image', 'is_indexable', 'created_by', 'updated_by',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(PostCategory::class, 'post_category_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    protected static function booted(): void
    {
        parent::booted();

        self::saving(function (self $post): void {
            $words = str_word_count(strip_tags((string) $post->body));
            $post->reading_time = max(1, (int) ceil($words / 200));
        });
    }

    protected function casts(): array
    {
        return [
            'status' => ContentStatus::class,
            'published_at' => 'datetime',
            'tags' => 'array',
            'is_featured' => 'boolean',
            'is_indexable' => 'boolean',
        ];
    }
}
