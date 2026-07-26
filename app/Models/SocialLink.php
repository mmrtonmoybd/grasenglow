<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

final class SocialLink extends CmsModel
{
    /** @use HasFactory<\Database\Factories\SocialLinkFactory> */
    use HasFactory;

    protected $fillable = [
        'platform', 'label', 'url', 'icon', 'sort_order', 'is_active', 'open_in_new_tab',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean', 'open_in_new_tab' => 'boolean'];
    }
}
