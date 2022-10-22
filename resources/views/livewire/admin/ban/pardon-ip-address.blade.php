<div>
    <form wire:submit.prevent="submit">
        @csrf

        <div class="mb-3">
            <label class="form-label" for="ip_address">{{ __('IPv4 address') }} <span class="text-danger">*</span></label>
            <input id="ip_address" wire:model.lazy="ip_address" @class(['form-control', 'is-invalid' => $errors->has('ip_address')]) type="text" required>

            @error ('ip_address')
                <div class="invalid-feedback" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button class="btn btn-warning" type="submit">
            <i class="fa-solid fa-scale-balanced me-1"></i>{{ __('Pardon Ban') }}
        </button>
    </form>
</div>
