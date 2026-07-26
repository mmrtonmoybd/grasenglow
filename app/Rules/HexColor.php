<?php

declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

final class HexColor implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || preg_match('/^#[0-9a-fA-F]{6}$/', $value) !== 1) {
            $fail('The :attribute must be a six-digit hexadecimal color.');
        }
    }
}
