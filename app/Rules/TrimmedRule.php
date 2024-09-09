<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class TrimmedRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        if (!filled($value)) {
            return;
        }
        $trimmedValue = trim($value);

        if (!($trimmedValue === $value)) {
            $fail('The :attribute must be trimmed.');
        }
    }
}
