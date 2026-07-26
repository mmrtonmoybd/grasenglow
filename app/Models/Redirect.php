<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Validation\ValidationException;

final class Redirect extends CmsModel
{
    /** @use HasFactory<\Database\Factories\RedirectFactory> */
    use HasFactory;

    protected $fillable = [
        'old_path', 'destination_url', 'status_code', 'is_active', 'hit_count', 'created_by', 'updated_by',
    ];

    protected static function booted(): void
    {
        parent::booted();

        self::saving(function (self $redirect): void {
            if (! str_starts_with($redirect->old_path, '/') || ! str_starts_with($redirect->destination_url, '/')) {
                throw ValidationException::withMessages(['destination_url' => 'Redirects must use local paths beginning with /.']);
            }

            if ($redirect->old_path === $redirect->destination_url) {
                throw ValidationException::withMessages(['destination_url' => 'A redirect cannot point to itself.']);
            }

            if (! in_array($redirect->status_code, [301, 302, 307, 308], true)) {
                throw ValidationException::withMessages(['status_code' => 'Unsupported redirect status code.']);
            }
        });
    }

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }
}
