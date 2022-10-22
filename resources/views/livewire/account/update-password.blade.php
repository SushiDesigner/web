<div class="card mt-3">
    <div class="card-body">
        <form wire:submit.prevent="submit">
            @csrf

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

            <div class="mb-3" x-data="{ show: false }">
                <label class="form-label" for="password">{{ __('New Password') }}</label>

                <div class="input-group">
                    <input :type="show ? 'text' : 'password'" @class(['form-control', 'is-invalid' => $errors->has('password')]) wire:model.lazy="password" id="password" required>
                    <button class="btn btn-dark" type="button" @@click="show = !show" tabindex="-1"><i class="fa-regular" :class="{ 'fa-eye': show, 'fa-eye-slash': !show }"></i></button>
                    
                    @error ('password')
                        <div class="invalid-feedback" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="mb-3" x-data="{ show: false }">
                <label class="form-label" for="password_confirmation">{{ __('Confirm New Password') }}</label>

                <div class="input-group">
                    <input :type="show ? 'text' : 'password'" @class(['form-control', 'is-invalid' => $errors->has('password_confirmation')]) wire:model.lazy="password_confirmation" id="password_confirmation" required>
                    <button class="btn btn-dark" type="button" @@click="show = !show" tabindex="-1"><i class="fa-regular" :class="{ 'fa-eye': show, 'fa-eye-slash': !show }"></i></button>
                    
                    @error ('password_confirmation')
                        <div class="invalid-feedback" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary">{{ __('Update Password') }}</button>
        </form>
    </div>
</div>
