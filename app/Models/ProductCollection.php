<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ContentStatus;
use App\Models\Concerns\HasPublicationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class ProductCollection extends CmsModel
{
    /** @use HasFactory<\Database\Factories\ProductCollectionFactory> */
    use HasFactory, HasPublicationStatus, SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'subtitle', 'short_description', 'description', 'cover_image', 'cover_image_alt',
        'banner_image', 'banner_image_alt', 'status', 'published_at', 'sort_order', 'is_featured',
        'meta_title', 'meta_description', 'meta_keywords', 'canonical_url', 'open_graph_image',
        'created_by', 'updated_by',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_collection_product');
    }

    protected function casts(): array
    {
        return [
            'status' => ContentStatus::class,
            'published_at' => 'datetime',
            'is_featured' => 'boolean',
        ];
    }
}
