<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\ValidationException;

final class ProductCategory extends CmsModel
{
    /** @use HasFactory<\Database\Factories\ProductCategoryFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'parent_id', 'name', 'slug', 'short_description', 'description', 'featured_image',
        'featured_image_alt', 'banner_image', 'banner_image_alt', 'icon', 'sort_order', 'is_featured',
        'is_active', 'show_when_empty', 'meta_title', 'meta_description', 'meta_keywords',
        'canonical_url', 'open_graph_image', 'created_by', 'updated_by',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->where('is_active', true)->orderBy('sort_order');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    protected static function booted(): void
    {
        parent::booted();

        self::saving(function (self $category): void {
            if ($category->parent_id === null || $category->id === null) {
                return;
            }

            $descendantIds = $category->children()->pluck('id');

            if ($category->parent_id === $category->id || $descendantIds->contains($category->parent_id)) {
                throw ValidationException::withMessages(['parent_id' => 'A category cannot be its own descendant.']);
            }
        });
    }

    #[Scope]
    protected function active(Builder $query): void
    {
        $query->where('is_active', true);
    }

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'show_when_empty' => 'boolean',
        ];
    }
}
