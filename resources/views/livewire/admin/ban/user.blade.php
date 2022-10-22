<div>
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
            <label class="form-label" for="moderator_note">{{ __('Moderator Note (shown to user)') }} <span class="text-danger">*</span></label>
            <input id="moderator_note" wire:model.lazy="moderator_note" @class(['form-control', 'is-invalid' => $errors->has('moderator_note')]) type="text" required>

            @error ('moderator_note')
                <div class="invalid-feedback" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" for="internal_reason">{{ __('Internal Reason (shown to moderators only)') }} <span class="text-danger">*</span></label>
            <input type="text" id="internal_reason" wire:model.lazy="internal_reason" @class(['form-control', 'is-invalid' => $errors->has('internal_reason')]) required>

            @error ('internal_reason')
                <div class="invalid-feedback" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" for="offensive_item">{{ __('Offensive Item (shown to user, formatted via Markdown)') }}</label>
            <textarea id="offensive_item" wire:model.lazy="offensive_item" @class(['form-control', 'is-invalid' => $errors->has('offensive_item')])></textarea>

            @error ('offensive_item')
                <div class="invalid-feedback d-block" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" for="duration_preset">{{ __('Ban duration:') }} <span class="text-danger">*</span></label>
            <select class="form-select" aria-label="{{ __('Ban duration') }}" id="duration_preset" wire:model.lazy="duration_preset">
                <option value="0">{{ __('Warning') }}</option>
                <option value="1">{{ __('1 day') }}</option>
                <option value="2">{{ __('3 days') }}</option>
                <option value="3">{{ __('7 days') }}</option>
                <option value="4">{{ __('14 days') }}</option>
                <option value="5">{{ __('Account Termination') }}</option>
                <option value="6">{{ __('Custom') }}</option>

                @may (Users::roleset(), Users::MODERATION_POISON_BAN)
                    <option value="7">{{ __('Poison Ban') }}</option>
                @endmay
            </select>
        </div>

        <div id="datepicker" class="d-none mb-3">
            <label class="form-label" for="custom_expiry_date">{{ __('Custom ban expiry date') }} <span class="text-danger">*</span></label>
            <div class="input-group">
                <input id="custom_expiry_date" wire:model.lazy="custom_expiry_date" @class(['form-control', 'is-invalid' => $errors->has('custom_expiry_date')]) type="text">
                <span class="input-group-text"><i class="fa-solid fa-calendar-days"></i></span>
            </div>

            @error ('custom_expiry_date')
                <div class="invalid-feedback d-block" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="is_appealable" wire:model.lazy="is_appealable">
            <label class="form-check-label" for="is_appealable">{{ __('Indicate that this ban is appealable') }}</label>
        </div>

        <button class="btn btn-danger" type="submit">
            <i class="fa-solid fa-user-slash me-1"></i>{{ __('Ban User') }}
        </button>
    </form>
</div>
