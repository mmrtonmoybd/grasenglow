<?php

declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

final class SafeUrl implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || mb_strlen($value) > 2048) {
            $fail('The :attribute must be a valid URL.');

            return;
        }

        if (str_starts_with($value, '/') || str_starts_with($value, '#')) {
            return;
        }

        $scheme = mb_strtolower((string) parse_url($value, PHP_URL_SCHEME));

        if (! in_array($scheme, ['http', 'https', 'mailto', 'tel'], true)) {
            $fail('The :attribute uses an unsafe or unsupported protocol.');
        }
    }
}
