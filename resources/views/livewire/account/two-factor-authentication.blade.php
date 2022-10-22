<div>
    <div class="card mt-3">
        <div class="card-body">
            @if (Auth::user()->two_factor_secret)
                <h3>{{ __('Two factor authentication is enabled!') }}</h3>
            @else
                <h3>{{ __('Two factor authentication is disabled.') }}</h3>
            @endif
            <p>{{ __('Two factor authentication requires you to take an extra step when logging in to your :project account. Some actions on :project may require you to have two factor authentication enabled.', ['project' => config('app.name')]) }}</p>

            @if (Auth::user()->two_factor_secret)
                <p class="mb-0"><button class="btn btn-danger" wire:click="disable">{{ __('Disable') }}</button></p>
            @else
                <p class="mb-0"><button class="btn btn-primary" wire:click="enable">{{ __('Enable') }}</button></p>
            @endif
        </div>
    </div>
</div>
