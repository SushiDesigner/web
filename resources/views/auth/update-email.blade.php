<x-auth-layout :title="__('Update E-Mail Address')">
    <span class="mb-3 d-block text-center">{!! __('Your E-Mail address is currently <b>:email</b>.', ['email' => e(Auth::user()->email)]) !!}</span>

    <form method="post" action="{{ route('account.email.update') }}">
        @csrf

        <div class="mb-3">
            <label for="password" class="form-label">{{ __('New E-Mail') }}</label>
            <input @class(['form-control', 'is-invalid' => $errors->has('email')]) name="email" id="email" required>

            @error ('email')
                <div class="invalid-feedback" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3" x-data="{ show: false }">
            <label for="current_password" class="form-label">{{ __('Current Password') }}</label>

            <div class="input-group">
                <input :type="show ? 'text' : 'password'" @class(['form-control', 'is-invalid' => $errors->has('current_password')]) name="current_password" id="current_password" required>
                <button class="btn btn-dark" type="button" @@click="show = !show" tabindex="-1"><i class="fa-regular" :class="{ 'fa-eye': show, 'fa-eye-slash': !show }"></i></button>
            </div>

            @error ('current_password')
                <div class="invalid-feedback d-block" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button class="btn btn-primary w-100" type="submit">{{ __('Update E-Mail Address') }}</button>
    </form>
</x-app-layout>
