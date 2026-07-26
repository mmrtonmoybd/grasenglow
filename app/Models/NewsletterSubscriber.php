<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

final class NewsletterSubscriber extends CmsModel
{
    /** @use HasFactory<\Database\Factories\NewsletterSubscriberFactory> */
    use HasFactory;

    protected $fillable = ['email', 'source_page', 'subscribed_at', 'is_active'];

    protected function casts(): array
    {
        return ['subscribed_at' => 'datetime', 'is_active' => 'boolean'];
    }
}
