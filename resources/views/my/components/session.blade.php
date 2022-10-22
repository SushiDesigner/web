<div id="session">
    <div @class(['p-4', 'border-top' => isset($revokable)])>
        <div class="d-flex justify-content-start">
            <div class="d-flex align-items-center me-3">
                <i @class(['fa-solid fa-circle rounded-circle', 'text-success glowing-online' => is_online($ping), 'text-secondary' => !is_online($ping)])></i>
            </div>

            <div class="d-flex align-items-center justify-content-center">
                <i @class(['fa-regular fa-fw fa-3x me-3', $agent->icon()]) data-bs-placement="bottom" data-bs-toggle="tooltip" title="{{ __(':browser on :platform', ['browser' => $agent->browser(), 'platform' => $agent->platform()]) }}"></i>
            </div>

            <div>
                <h5 class="mb-1">
                    @if ($location !== false)
                        <b>{{ __(':region, :country', ['region' => $location->region, 'country' => $location->country]) }}</b>
                    @else
                        <b>{{ __('Unknown') }}</b>
                    @endif
                    -
                    <span class="text-muted">{{ $ip }}</span>
                </h5>

                @isset ($revokable)
                    @if (is_online($ping))
                        {{ __('Last accessed recently') }}
                    @else
                        {{ __('Last accessed :time ago', ['time' => seconds2human(time() - $ping, true)]) }}
                    @endif
                @else
                    {{ __('Your current session') }}
                @endif
            </div>

            @isset ($revokable)
                <div class="ms-auto d-md-inline-block d-none d-flex align-items-center">
                    <button class="btn btn-danger" data-tadah-toggle="sign-out" data-tadah-key="{{ $key }}">{{ __('Sign out') }}</button>
                </div>
            @endisset
        </div>

        @isset ($revokable)
            <button class="btn btn-danger d-md-none w-100 mt-4" data-tadah-toggle="sign-out" data-tadah-key="{{ $key }}">{{ __('Sign out') }}</button>
        @endisset
    </div>
</div>
