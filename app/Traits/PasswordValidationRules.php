<?php

namespace App\Traits;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @var ?string $username The username being used.
     * @var ?string $email The email address being used.
     *
     * @return array
     */
    protected function passwordRules(?string $username = null, ?string $email = null): array
    {
        $username = $username ?? '';
        $email = $email ?? '';

        $zxcbvn_dictionary = sprintf('zxcvbn_dictionary:%s,%s', base64_encode($username), base64_encode($email));

        return ['required', 'string', 'min:12', 'zxcvbn_min:3', $zxcbvn_dictionary];
    }

    /**
     * Get the validation rules used to validate password confirmations.
     */
    protected function passwordConfirmationRules(): array
    {
        return ['required', 'string', 'same:password'];
    }
}
