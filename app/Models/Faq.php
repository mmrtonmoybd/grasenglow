<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

final class Faq extends CmsModel
{
    /** @use HasFactory<\Database\Factories\FaqFactory> */
    use HasFactory;

    protected $fillable = [
        'category', 'question', 'answer', 'sort_order', 'is_active', 'show_on_homepage', 'created_by', 'updated_by',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean', 'show_on_homepage' => 'boolean'];
    }
}
