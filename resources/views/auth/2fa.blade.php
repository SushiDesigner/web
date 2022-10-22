<x-auth-layout :title="__('Two Factor Authentication')">
    <form method="post" action="{{ route('two-factor.login') }}">
        @csrf

        <div class="mb-3" x-data="{ show: false }">
            <label for="code" class="form-label">{{ __('Two Factor Code') }}</label>

            <div class="input-group">
                <input :type="show ? 'text' : 'code'" @class(['form-control', 'is-invalid' => $errors->has('code')]) name="code" id="code" required>
            </div>

            @error ('code')
                <div class="invalid-feedback d-block" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button class="btn btn-primary w-100" type="submit">{{ __('Submit') }}</button>
    </form>
</x-app-layout>
