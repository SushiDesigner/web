<x-auth-layout :title="__('Login')">
    <x-slot:head>
        {!! htmlScriptTagJsApi() !!}
    </x-slot>

    <form method="post" id="{{ getFormId() }}">
        @csrf

        <div class="mb-3">
            <label for="username" class="form-label">{{ __('Username') }}</label>
            <input type="text" @class(['form-control', 'is-invalid' => $errors->has('username')]) name="username" id="username" value="{{ old('username') }}" required>

            @error ('username')
                <div class="invalid-feedback" role="alert">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">{{ __('Password') }}</label>
            <input type="password" class="form-control" name="password" id="password" required>
        </div>

        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" id="remember" name="remember">
            <label class="form-check-label" for="remember">{{ __('Remember me') }}</label>
        </div>

        <div class="d-flex align-items-center justify-content-end">
            <a href="{{ route('password.request') }}" class="me-3">{{ __('Forgot your password?') }}</a>
            {!! htmlFormButton('<i class="fa-solid fa-sign-in-alt me-1"></i>' . __('Login'), ['class' => 'btn btn-primary']) !!}
        </div>
    </form>
</x-app-layout>
