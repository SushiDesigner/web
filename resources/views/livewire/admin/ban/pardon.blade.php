<div>
    <p>{{ __('Only manually pardon users in the case of an error. If you wish to lift poison bans, please use the username of the patient zero.') }}</p>

    <form wire:submit.prevent="submit">
        @csrf

        <div class="mb-3">
            <label class="form-label" for="username">{{ __('Username') }} <span class="text-danger">*</span></label>
            <input id="username" wire:model.lazy="username" @class(['form-control', 'is-invalid' => $errors->has('username')]) type="text" required>

            @error ('username')
                <div class="invalid-feedback" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" for="why">{{ __('Pardon reason (shown to moderators only)') }} <span class="text-danger">*</span></label>
            <input id="pardon_reason" wire:model.lazy="pardon_reason" @class(['form-control', 'is-invalid' => $errors->has('pardon_reason')]) type="text" required>

            @error ('pardon_reason')
                <div class="invalid-feedback" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button class="btn btn-warning" type="submit">
            <i class="fa-solid fa-scale-balanced me-1"></i>{{ __('Pardon User') }}
        </button>
    </form>
</div>
