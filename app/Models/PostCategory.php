<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class PostCategory extends CmsModel
{
    /** @use HasFactory<\Database\Factories\PostCategoryFactory> */
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'is_active'];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }
}
