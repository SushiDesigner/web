<x-auth-layout :title="__('Confirm Password')">
    <form method="post" action="{{ route('password.confirm') }}">
        @csrf

        <div class="mb-3" x-data="{ show: false }">
            <label for="password" class="form-label">{{ __('Confirm Password') }}</label>

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

        <button class="btn btn-primary w-100" type="submit">{{ __('Submit') }}</button>
    </form>
</x-app-layout>
