<x-auth-layout :title="__('Reset Password')">
    <form method="post" action="{{ route('password.update') }}">
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">
        @csrf

        <div class="mb-3" x-data="{ show: false }">
            <label for="password" class="form-label">{{ __('New Password') }}</label>

            <div class="input-group">
                <input :type="show ? 'text' : 'password'" @class(['form-control', 'is-invalid' => $errors->has('password')]) name="password" id="password" required>
                <button class="btn btn-dark" type="button" @@click="show = !show" tabindex="-1"><i class="fa-regular" :class="{ 'fa-eye': show, 'fa-eye-slash': !show }"></i></button>
            </div>

            @error ('password')
                <div class="invalid-feedback d-block" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3" x-data="{ show: false }">
            <label for="password_confirmation" class="form-label">{{ __('Confirm New Password') }}</label>

            <div class="input-group">
                <input :type="show ? 'text' : 'password'" @class(['form-control', 'is-invalid' => $errors->has('password_confirmation')]) name="password_confirmation" id="password_confirmation" required>
                <button class="btn btn-dark" type="button" @@click="show = !show" tabindex="-1"><i class="fa-regular" :class="{ 'fa-eye': show, 'fa-eye-slash': !show }"></i></button>
            </div>

            @error ('password_confirmation')
                <div class="invalid-feedback d-block" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button class="btn btn-primary w-100" type="submit">{{ __('Reset Password') }}</button>
    </form>
</x-app-layout>
