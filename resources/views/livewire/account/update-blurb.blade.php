<form wire:submit.prevent="submit">
    @csrf

    <div class="mb-3">
        <label class="form-label" for="blurb">{{ __('Blurb') }}</label>
        <textarea wire:model.lazy="blurb" @class(['form-control', 'is-invalid' => $errors->has('blurb')]) rows="4" placeholder="{{ __('Let people know more about you') }}"></textarea>

        @error ('blurb')
            <div class="invalid-feedback" role="alert">
                {{ $message }}
            </div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">{{ __('Update Blurb') }}</button>
</form>
