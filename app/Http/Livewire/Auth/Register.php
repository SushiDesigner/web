<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use App\Models\PoisonedIpAddress;
use App\Rules\IsValidInviteKey;
use App\Traits\PasswordValidationRules;
use App\Traits\UsernameValidationRules;
use App\Traits\EmailValidationRules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class Register extends Component
{
    use PasswordValidationRules, UsernameValidationRules, EmailValidationRules;

    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $password_confirmation;

    /**
     * @var string
     */
    public $key;

    /**
     * @var mixed
     */
    public $tos;

    /**
     * @var mixed
     */
    public $age;

    /**
     * @var string
     */
    public $captcha;

    /**
     * @var array
     */
    public $input_began = [
        'username' => false,
        'email' => false,
        'password' => false,
        'password_confirmation' => false,
        'key' => false,
        'tos' => false,
        'age' => false,
    ];

    public function __construct()
    {
        abort_if(Auth::check(), 401);
        abort_unless(is_null(PoisonedIpAddress::whereEncrypted('ip_address', '=', Request::ip())->first()), 404);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'username' => $this->usernameRules(),
            'email' => $this->emailRules(),
            'password' => $this->passwordRules($this->username, $this->email),
            'password_confirmation' => $this->passwordConfirmationRules(),
            'tos' => ['required', 'min:1'],
            'age' => ['required', 'min:1'],
        ];

        if (config('tadah.invite_keys_required'))
        {
            $rules['key'] = ['required', 'string', new IsValidInviteKey()];
        }

        return $rules;
    }

    public function data()
    {
        return $this->unwrapDataForValidation($this->prepareForValidation($this->getDataForValidation($this->rules())));
    }

    public function render()
    {
        $bag = $this->getErrorBag();

        $icon = function ($field) use ($bag) {
            if ($field == 'documents')
            {
                return match (true)
                {
                    $bag->has('tos') || $bag->has('age') => 'fa-xmark',
                    !$bag->has('tos') && !$bag->has('age') && $this->input_began['tos'] && $this->input_began['age'] => 'fa-check',
                    default => 'fa-hyphen'
                };
            }

            return match(true)
            {
                $bag->has($field) && $this->input_began[$field] => 'fa-xmark',
                !$bag->has($field) && $this->input_began[$field] => 'fa-check',
                default => 'fa-hyphen'
            };
        };

        $status = function ($field) use ($bag) {
            return match(true)
            {
                $bag->has($field) && $this->input_began[$field] => 'is-invalid',
                !$bag->has($field) && $this->input_began[$field] && $field != 'tos' && $field != 'age' => 'is-valid',
                default => null
            };
        };

        $feedback = function ($field) use ($icon) {
            return match($icon($field)) {
                'fa-xmark' => 't_error-feedback',
                'fa-check' => 't_success-feedback',
                'fa-hyphen' => 't_disabled-feedback'
            };
        };

        return view('livewire.auth.register', compact('icon', 'status', 'feedback'));
    }

    public function updated($property)
    {
        if ($property == 'captcha')
        {
            return;
        }

        $this->input_began[$property] = true;

        $validator = validator($this->data(), $this->rules());
        $this->dispatchBrowserEvent('validated', !$validator->fails());

        $this->validateOnly($property);
    }

    public function register()
    {
        $captchaValidation = validator(['captcha' => $this->captcha], ['captcha' => ['required', recaptchaRuleName()]]);

        if ($captchaValidation->fails())
        {
            return $this->dispatchBrowserEvent('fatal', __('The captcha challenge failed. Please try again.'));
        }

        $primaryValidation = validator($this->data(), $this->rules());
        if ($primaryValidation->fails())
        {
            return $this->dispatchBrowserEvent('fatal', __('An unexpected error occurred. Please try again.'));
        }

        if (!is_null(PoisonedIpAddress::whereEncrypted('ip_address', '=', Request::ip())->first()))
        {
            return abort(404);
        }

        User::register($primaryValidation->validated(), Request::ip());

        return $this->dispatchBrowserEvent('register-complete');
    }
}
