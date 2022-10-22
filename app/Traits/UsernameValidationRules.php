<?php

namespace App\Traits;

use App\Rules\IsAlphaNumeric;
use App\Models\User;
use Illuminate\Validation\Rule;

trait UsernameValidationRules
{
    /**
     * Get the validation rules used to validate usernames.
     *
     * @return array
     */
    protected function usernameRules($column = 'NULL'): array
    {
        return ['required', 'string', 'min:3', 'max:20', new IsAlphaNumeric(), 'profane', Rule::unique(User::class, $column)];
    }
}
