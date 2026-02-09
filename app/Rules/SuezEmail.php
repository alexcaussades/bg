<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class SuezEmail implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Vérifie STRICTEMENT le domaine @suez.com
        if (!preg_match('/^[A-Za-z0-9._%+-]+@suez\.com$/', $value)) {
            $fail('Seules les adresses email se terminant par @suez.com sont autorisées.');
        }
    }
}
