<x-auth-layout :title="__('Forgot Password')">
    <x-slot:head>
        {!! htmlScriptTagJsApi() !!}
    </x-slot>

    <form method="post" id="{{ getFormId() }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">{{ __('E-Mail Address') }}</label>
            <input type="email" @class(['form-control', 'is-invalid' => $errors->has('email')]) name="email" id="email" value="{{ old('email') }}" required>

            @error ('email')
                <div class="invalid-feedback" role="alert">{{ $message }}</div>
            @enderror
        </div>

        {!! htmlFormButton('<i class="fa-solid fa-paper-plane me-1"></i>' . __('Send Password Reset Link'), ['class' => 'btn btn-primary w-100']) !!}

        @error ('g-recaptcha-response')
            <span class="text-danger">{{ __('An unexpected error occurred. Please try again.') }}
        @enderror
    </form>
</x-app-layout>
