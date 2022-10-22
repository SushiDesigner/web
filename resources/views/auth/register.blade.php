<x-app-layout :title="__('Register')" fluff="off">
    <x-slot:head>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    </x-slot>

    <main class="flex-shrink-0 d-flex align-items-center min-vh-100">
        <div class="w-100 d-grid">
            <div class="noob-register" data-tadah-magic="register-noob" style="display: none;">
                <div class="d-inline-flex flex-column text-center justify-content-center align-items-center">
                    <img class="img-fluid" src="{{ asset('img/noobs/rockin.png') }}" width="300" id="noob">
                    <br class="my-3">
                    <h2 class="motto mb-0">{{ __('Welcome to :project,', ['project' => config('app.name')]) }} <b id="register-name"></b>!</h2>
                    <span class="motto my-2" id="lie">{{ __('We\'re busy setting up your profile. Just a moment...') }}</span>
                    <span class="motto fst-italic mt-1 small-r" data-tadah-magic="state"><i class="fa-solid fa-spinner fa-spin me-1"></i><span id="text">{{ __('enumerating gibson instances...') }}</span></span>
                    <span class="t_success-feedback mt-1 small-r d-none" data-tadah-magic="completed"><i class="fa-solid fa-check me-1"></i>{{ __('account set up! redirecting...') }}</span>
                </div>
            </div>

            <div class="container vw-100" data-tadah-magic="register-main">
                <div class="mb-3 text-center d-lg-none d-block">
                    <a href="/"><img src="{{ asset('img/logo/small.png') }}" width="100"></a>
                </div>

                <div class="my-3 d-flex flex-column w-100">
                    <livewire:auth.register />

                    <div class="d-flex align-items-center mt-3">
                        <div class="ms-auto me-auto me-lg-0">
                            @include ('partials.language-dropdown')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>
