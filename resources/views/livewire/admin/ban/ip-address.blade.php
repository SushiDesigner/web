<div>
    <form wire:submit.prevent="submit">
        @csrf

        <div class="mb-3">
            <label class="form-label" for="identifier">{{ __('Username, E-Mail address, or IPv4 address') }} <span class="text-danger">*</span></label>
            <input id="identifier" wire:model.lazy="identifier" @class(['form-control', 'is-invalid' => $errors->has('identifier')]) type="text" required>

            @error ('username')
                <div class="invalid-feedback" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" for="internal_reason">{{ __('Internal Reason') }}</label>
            <input id="internal_reason" wire:model.lazy="internal_reason" @class(['form-control', 'is-invalid' => $errors->has('internal_reason')]) type="text">

            @error ('internal_reason')
                <div class="invalid-feedback" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button class="btn btn-danger" type="submit">
            <i class="fa-solid fa-block-brick-fire me-1"></i>{{ __('Ban IP Address') }}
        </button>
    </form>
</div>
