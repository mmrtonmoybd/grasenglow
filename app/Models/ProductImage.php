<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class ProductImage extends CmsModel
{
    /** @use HasFactory<\Database\Factories\ProductImageFactory> */
    use HasFactory;

    protected $fillable = ['product_id', 'image', 'alt_text', 'caption', 'sort_order', 'is_primary'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    protected static function booted(): void
    {
        parent::booted();

        self::saved(function (self $image): void {
            if ($image->is_primary) {
                self::query()
                    ->where('product_id', $image->product_id)
                    ->whereKeyNot($image->getKey())
                    ->update(['is_primary' => false]);
            }
        });
    }

    protected function casts(): array
    {
        return ['is_primary' => 'boolean'];
    }
}
