<div>
    <div class="modal-header">
        <h5 class="modal-title" id="usernameChangeHeader">{{ __('Change username') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}">
    </div>

    <form wire:submit.prevent="submit">
        @csrf

        <div class="modal-body">
            <span class="mb-3 d-block">{{ __('Changing your username costs :price :currency.', ['price' => config('tadah.username_change_cost'), 'currency' => config('tadah.currency_name')]) }}</span>

            <div class="mb-3">
                <label class="form-label" for="new_username">{{ __('New Username') }}</label>
                <input @class(['form-control', 'is-invalid' => $errors->has('new_username')]) type="text" id="new_username" wire:model.lazy="new_username" required>

                @error ('new_username')
                    <div class="invalid-feedback" role="alert">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3" x-data="{ show: false }">
                <label class="form-label" for="current_password">{{ __('Current Password') }}</label>

                <div class="input-group">
                    <input :type="show ? 'text' : 'password'" @class(['form-control', 'is-invalid' => $errors->has('current_password')]) wire:model.lazy="current_password" id="current_password" required>
                    <button class="btn btn-dark" type="button" @@click="show = !show" tabindex="-1"><i class="fa-regular" :class="{ 'fa-eye': show, 'fa-eye-slash': !show }"></i></button>
                
                    @error ('current_password')
                        <div class="invalid-feedback" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
            <button type="submit" class="btn btn-primary">{{ __('Buy new username') }}</button>
        </div>
    </form>
</div>
