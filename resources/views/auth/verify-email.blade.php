<x-auth-layout :title="__('Verify E-Mail')" width="email-w">
    <x-slot:head>
        {!! htmlScriptTagJsApi() !!}
    </x-slot>

    <div class="text-center">
        <h3 class="mb-3 fw-bold">{{ __('Please verify your email') }}</h3>
        <p>
            {{ __("You're almost there! We sent an email to") }}<br>
            <b>{{ Auth::user()->email }}</b><br><br>

            {{ __("Just click on the link in that email to complete your signup.") }}<br>
            {!! __("If you don't see it, you may need to <b>check your spam</b> folder.") !!}<br><br>

            {{ __("Still can't find the email?") }}
        </p>

        <form method="post" action="{{ route('verification.send') }}" id="{{ getFormId() }}">
            @csrf
            {!! htmlFormButton(__('Resend Email'), ['class' => 'btn btn-primary btn-lg']) !!}
        </form>

        <p class="mt-3 mb-0">
            {{ __('Need help?') }} <a href="{{ 'mailto:' . getInboxAddress() }}">{{ __('Contact Us') }}</a>
        </p>
    </div>

    <x-slot:bottom>
        <div class="mt-3 d-flex justify-content-between email-w">
            <div>
                <form method="post" action="{{ route('logout') }}">
                    @csrf
                    <a href="#" class="text-muted tadah-link-submit" type="submit">{{ __('Logout') }}</a>
                </form>
            </div>

            @include ('partials.language-dropdown')
        </div>
    </x-slot>
</x-app-layout>
