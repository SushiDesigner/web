<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\Rule;

class IsValidSession implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(
        protected User $user,
    ) {}

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return DB::table('sessions')
            ->where('user_id', $this->user->id)
            ->where('id', decrypt($value))
            ->first() !== null;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return __('Invalid session.');
    }
}
