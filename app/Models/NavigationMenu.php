<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class NavigationMenu extends CmsModel
{
    /** @use HasFactory<\Database\Factories\NavigationMenuFactory> */
    use HasFactory;

    protected $fillable = ['name', 'location', 'is_active', 'created_by', 'updated_by'];

    public function items(): HasMany
    {
        return $this->hasMany(NavigationItem::class)->orderBy('sort_order');
    }

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }
}
