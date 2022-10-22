<div class="card card-body">
    <form wire:submit.prevent="submit">
        @csrf

        <div class="mb-3">
            <label class="form-label" for="text">{{ __('Text') }} <span class="text-danger">*</span></label>
            <input @class(['form-control', 'is-invalid' => $errors->has('text')]) type="text" wire:model.lazy="text" id="text" placeholder="{{ __('Kyle Wagness has hacked this website.') }}" required>

            @error ('text')
                <div class="invalid-feedback" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" for="color">{{ __('Color') }} <span class="text-danger">*</span></label>
            <input @class(['form-control', 'is-invalid' => $errors->has('color')]) type="color" wire:model.defer="color" value="#ff0000" required>

            @error ('color')
                <div class="invalid-feedback" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" for="expiry">{{ __('Remove alert on') }}</label>

            <div class="input-group" id="datepicker">
                <input @class(['form-control', 'is-invalid' => $errors->has('expiry')]) wire:model.lazy="expiry" id="expiry">
                <span class="input-group-text"><i class="fa-solid fa-calendar-days"></i></span>
            </div>

            @error ('expiry')
                <div class="invalid-feedback" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button class="btn btn-primary" type="submit">
            <i class="fa-solid fa-megaphone me-1"></i>{{ __('Create Site Alert') }}
        </button>
    </form>
</div>
