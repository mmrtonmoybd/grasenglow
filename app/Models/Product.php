<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ContentStatus;
use App\Enums\ProductAvailabilityStatus;
use App\Models\Concerns\HasPublicationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Product extends CmsModel
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, HasPublicationStatus, SoftDeletes;

    protected $fillable = [
        'product_category_id', 'name', 'slug', 'sku', 'short_description', 'description', 'story',
        'materials', 'craftsmanship_details', 'sustainability_details', 'animal_support_details',
        'care_instructions', 'dimensions', 'weight', 'color_description', 'price', 'compare_price',
        'currency', 'availability_status', 'stock_quantity', 'made_to_order', 'lead_time',
        'inquiry_enabled', 'inquiry_button_label', 'inquiry_url', 'featured_image', 'featured_image_alt',
        'status', 'published_at', 'is_featured', 'is_new', 'sort_order', 'meta_title',
        'meta_description', 'meta_keywords', 'canonical_url', 'open_graph_title',
        'open_graph_description', 'open_graph_image', 'is_indexable', 'created_by', 'updated_by',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function collections(): BelongsToMany
    {
        return $this->belongsToMany(ProductCollection::class, 'product_collection_product');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function relatedProducts(): BelongsToMany
    {
        return $this->belongsToMany(self::class, 'related_products', 'product_id', 'related_product_id');
    }

    protected function casts(): array
    {
        return [
            'status' => ContentStatus::class,
            'availability_status' => ProductAvailabilityStatus::class,
            'published_at' => 'datetime',
            'price' => 'decimal:2',
            'compare_price' => 'decimal:2',
            'weight' => 'decimal:2',
            'made_to_order' => 'boolean',
            'inquiry_enabled' => 'boolean',
            'is_featured' => 'boolean',
            'is_new' => 'boolean',
            'is_indexable' => 'boolean',
        ];
    }
}
