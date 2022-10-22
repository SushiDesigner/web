<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\InviteKey;

class IsValidInviteKey implements Rule
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
        $key = InviteKey::whereEncrypted('token', '=', $value)->first();

        if ($key && $key->isValid())
        {
            return true;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return __('Invalid invite key.');
    }
}
