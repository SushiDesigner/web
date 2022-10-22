<div data-tadah-magic="register">
    <div class="card border-0 shadow rounded-4">
        <div class="row row-cols-lg-2 row-cols-1 g-0">
            <div class="col col-md-12 col-lg-5">
                <div class="card-body p-4">
                    <form wire:submit.prevent="register">
                        @csrf

                        <div class="mb-3">
                            <label for="username" class="form-label">{{ __('Name') }}</label>
                            <input type="text" @class(['form-control', $status('username')]) wire:model.lazy="username" id="username" required>

                            @error ('username')
                                <div class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('E-Mail Address') }}</label>
                            <input type="email" @class(['form-control', $status('email')]) wire:model.lazy="email" id="email" required>

                            @error ('email')
                                <div class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3" x-data="{ show: false }">
                            <label for="password" class="form-label">{{ __('Password') }}</label>

                            <div class="input-group">
                                <input :type="show ? 'text' : 'password'" @class(['form-control', $status('password')]) wire:model.lazy="password" id="password" aria-describedBy="password-help" required>
                                <button class="btn btn-dark" type="button" @@click="show = !show" tabindex="-1"><i class="fa-regular" :class="{ 'fa-eye': show, 'fa-eye-slash': !show }"></i></button>
                            </div>

                            @error ('password')
                                <div class="invalid-feedback d-block" role="alert">
                                    {{ $message }}
                                </div>
                            @else
                                <div id="password-help" class="form-text">
                                    {!! __('<span class="user-select-none">Passwords are stored via</span> <a href="https://en.wikipedia.org/wiki/Argon2" class="user-select-auto" tabindex="-1">Argon2id</a>.</span>') !!}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3"  x-data="{ show: false }">
                            <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>

                            <div class="input-group">
                                <input :type="show ? 'text' : 'password'" @class(['form-control', $status('password_confirmation')]) wire:model.lazy="password_confirmation" id="password_confirmation" required>
                                <button class="btn btn-dark" type="button" @@click="show = !show" tabindex="-1"><i class="fa-regular" :class="{ 'fa-eye': show, 'fa-eye-slash': !show }"></i></button>
                            </div>

                            @error ('password_confirmation')
                                <div class="invalid-feedback d-block" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        @if (config('tadah.invite_keys_required'))
                            <div class="mb-3">
                                <label for="key" class="form-label">{{ __('Invite Key') }}</label>
                                <input type="text" @class(['font-monospace form-control', $status('key')]) wire:model.lazy="key" id="key" required>

                                @error ('key')
                                    <div class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        @endif

                        <div class="form-check">
                            <input @class(['form-check-input', $status('tos')]) type="checkbox" id="tos" wire:model="tos" required>
                            <label class="form-check-label" for="tos">{!! __('I have read and agree to the <a href=":link" tabindex="-1">:project Terms of Service</a>', ['link' => route('document', 'tos'), 'project' => e(config('app.name'))]) !!}</label>
                        </div>

                        <div class="form-check">
                            <input @class(['form-check-input', $status('age')]) type="checkbox" id="age" wire:model="age" required>
                            <label class="form-check-label" for="age">{{ __('I am 13 years old or older') }}</label>
                        </div>

                        <div class="d-flex align-items-center justify-content-end mt-2" wire:ignore>
                            <a href="{{ route('login') }}" class="me-3">{{ __('Already have an account?') }}</a>
                            <button class="btn btn-primary g-recaptcha" id="register-button" data-callback="registerCallback" data-sitekey="{{ config('recaptcha.api_site_key') }}"><i class="fa-solid fa-user-plus me-1"></i>{{ __('Sign Up') }}</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col col-lg-7 align-items-center justify-content-center py-5 register-hero d-lg-inline-flex d-none">
                <div class="container text-center w-auto user-select-none">
                    <a href="/"><img src="{{ asset('img/logo/big.png') }}" width="400" class="mb-1 img-fluid"></a><br>
                    <p class="text-light h5 motto my-3 px-4">{!! __("<b>Welcome to :project!</b> In order to register, you'll need to do the following:", ['project' => e(config('app.name'))]) !!}</p>

                    <p class="text-start mx-auto w-75">
                        <span @class([$feedback('username')])>
                            <i @class(['fa-solid fa-fw me-2', $icon('username')])></i>
                            {{ __('Choose an appropriate, alphanumeric username less than 20 characters') }}
                        </span><br>

                        <span @class([$feedback('email')])>
                            <i @class(['fa-solid fa-fw me-2', $icon('email')])></i>
                            {{ __('Provide a valid E-Mail Address (will be verified)') }}
                        </span><br>

                        <span @class([$feedback('password')])>
                            <i @class(['fa-solid fa-fw me-2', $icon('password')])></i>
                            {{ __('Create a strong password, more than 12 characters') }}
                        </span><br>

                        <span @class([$feedback('password_confirmation')])>
                            <i @class(['fa-solid fa-fw me-2', $icon('password_confirmation')])></i>
                            {{ __('Confirm your password') }}
                        </span><br>

                        @if (config('tadah.invite_keys_required'))
                            <span @class([$feedback('key')])>
                                <i @class(['fa-solid fa-fw me-2', $icon('key')])></i>
                                {{ __('Enter your invite key') }}
                            </span><br>
                        @endif

                        <span @class([$feedback('documents')])>
                            <i @class(['fa-solid fa-fw me-2', $icon('documents')])></i>
                            {{ __('Sign the documents') }}
                        </span><br>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
