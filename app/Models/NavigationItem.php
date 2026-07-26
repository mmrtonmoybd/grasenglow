<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\LinkType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

final class NavigationItem extends CmsModel
{
    /** @use HasFactory<\Database\Factories\NavigationItemFactory> */
    use HasFactory;

    protected $fillable = [
        'navigation_menu_id', 'parent_id', 'label', 'link_type', 'link_value', 'icon', 'sort_order',
        'is_active', 'open_in_new_tab', 'nofollow', 'show_on_desktop', 'show_on_mobile',
    ];

    public function menu(): BelongsTo
    {
        return $this->belongsTo(NavigationMenu::class, 'navigation_menu_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->where('is_active', true)->orderBy('sort_order');
    }

    public function resolvedUrl(): string
    {
        if ($this->link_type === LinkType::Anchor) {
            return '#'.mb_ltrim($this->link_value, '#');
        }

        if ($this->link_type === LinkType::External) {
            return Str::startsWith($this->link_value, ['https://', 'http://']) ? $this->link_value : '#';
        }

        return '/'.mb_ltrim($this->link_value, '/');
    }

    protected static function booted(): void
    {
        parent::booted();

        self::saving(function (self $item): void {
            if ($item->parent_id === null) {
                return;
            }

            $parent = self::query()->find($item->parent_id);

            if ($parent === null || $parent->id === $item->id || $parent->navigation_menu_id !== $item->navigation_menu_id || $parent->parent_id !== null) {
                throw ValidationException::withMessages(['parent_id' => 'Choose a top-level item from the same menu. Navigation supports two levels.']);
            }
        });
    }

    protected function casts(): array
    {
        return [
            'link_type' => LinkType::class,
            'is_active' => 'boolean',
            'open_in_new_tab' => 'boolean',
            'nofollow' => 'boolean',
            'show_on_desktop' => 'boolean',
            'show_on_mobile' => 'boolean',
        ];
    }
}
