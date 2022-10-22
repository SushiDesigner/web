<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class IsAlphaNumeric implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return ctype_alnum($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return __('The :attribute must only contain alphanumeric characters.');
    }
}
