<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MatchColorQuantities implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Calculate the sum from the request input
        $colorsSum = collect(request()->input('colors'))->sum('quantity');

        // If the values do not match, trigger the $fail closure
        if ((int) $value !== (int) $colorsSum) {
            $fail('The total quantity must match the sum of color quantities.');
        }
    }
}
