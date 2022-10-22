<?php

namespace App\Traits;

trait EmailValidationRules
{
    /**
     * Get the validation rules used to validate usernames.
     *
     * @return array
     */
    protected function emailRules(): array
    {
        return ['required', 'string', 'max:255', 'email', 'indisposable'];
    }
}
