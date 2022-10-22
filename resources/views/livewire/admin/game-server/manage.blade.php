<div class="card card-body">
    <form wire:submit.prevent="submit">
        @csrf

        <div class="mb-3">
            <label class="form-label" for="ip_address">{{ __('IP Address') }}</label>
            <input @class(['form-control', 'is-invalid' => $errors->has('ip_address')]) type="text" wire:model.lazy="ip_address" id="ip_address" required>

            @error ('ip_address')
                <div class="invalid-feedback" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" for="maximum_place_jobs">{{ __('Maximum Game Jobs') }}</label>
            <input @class(['form-control', 'is-invalid' => $errors->has('maximum_place_jobs')]) type="number" wire:model.lazy="maximum_place_jobs" id="maximum_place_jobs" required>

            @error ('maximum_place_jobs')
                <div class="invalid-feedback" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" for="maximum_thumbnail_jobs">{{ __('Maximum Thumbnail Jobs') }}</label>
            <input @class(['form-control', 'is_invalid' => $errors->has('maximum_thumbnail_jobs')]) type="number" wire:model.lazy="maximum_thumbnail_jobs" id="maximum_thumbnail_jobs" required>

            @error ('maximum_thumbnail_jobs')
                <div class="invalid-feedback" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" for="port">{{ __('Tadah.Arbiter running port') }}</label>
            <input @class(['form-control', 'is_invalid' => $errors->has('port')]) type="number" wire:model.lazy="port" id="port" required>

            @error ('port')
                <div class="invalid-feedback" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-check mb-3">
            <label class="form-check-label" for="has_vnc">{{ __('Game Server has VNC') }}</label>
            <input class="form-check-input" type="checkbox" id="has_vnc" wire:model.lazy="has_vnc">
        </div>

        <div class="mb-3 d-none">
            <label class="form-label" for="vnc_port">{{ __('VNC port') }} <span class="text-danger">*</span></label>
            <input @class(['form-control', 'is_invalid' => $errors->has('vnc_port')]) type="number" wire:model.lazy="vnc_port" id="vnc_port">

            @error ('vnc_port')
                <div class="invalid-feedback" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3 d-none">
            <label class="form-label" for="vnc_password">{{ __('VNC password') }}</label>
            <input @class(['form-control', 'is_invalid' => $errors->has('vnc_password')]) type="number" wire:model.lazy="vnc_password" id="vnc_password">

            @error ('vnc_password')
                <div class="invalid-feedback" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button class="btn btn-success text-light me-1" type="submit">
            <i class="fa-solid fa-pencil me-1"></i>{{ __('Update Game Server') }}
        </button>
    </form>
</div>
