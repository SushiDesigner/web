<span @class([
    'd-flex align-items-center',
    'text-warning' => $gameServer->state() == GameServerState::Paused,
    'text-success' => $gameServer->state() == GameServerState::Online,
    'text-danger' => $gameServer->state() == GameServerState::Crashed,
    'text-info' => !$gameServer->is_set_up,
    'text-muted' => $gameServer->state() == GameServerState::Offline && $gameServer->is_set_up
]) id="status">
    <i @class([
        'fa-solid me-1 fa-2xs',
        'fa-moon' => $gameServer->state() == GameServerState::Paused,
        'fa-plug-circle-exclamation' => $gameServer->state() == GameServerState::Crashed,
        'fa-circle' => $gameServer->state() != GameServerState::Paused && $gameServer->state() != GameServerState::Crashed,
    ])></i>

    <span>
        @if ($gameServer->is_set_up)
            @if ($gameServer->state() == GameServerState::Online)
                {{ __('Online') }}
            @elseif ($gameServer->state() == GameServerState::Paused)
                {{ __('Paused') }}
            @elseif ($gameServer->state() == GameServerState::Crashed)
                {{ __('Crashed') }}
            @else
                {{ __('Offline') }}
            @endif
        @else
            {{ __('Setting Up') }}
        @endif
    </span>
</span>

<span @class(['text-muted me-1', 'd-none' => $gameServer->state() != GameServerState::Online]) id="running-place-jobs">
    <span class="mx-1">|</span>

    <span id="amount">
        @if ($gameServer->state() == GameServerState::Online)
            {{ __(':amount running place job(s)', ['amount' => number_format(count($gameServer->getRunningPlaceJobs()))]) }}
        @endif
    </span>
</span>

<span @class(['text-muted me-1', 'd-none' => $gameServer->state() != GameServerState::Online]) id="running-thumbnail-jobs">
    <span class="mx-1">|</span>

    <span id="amount">
        @if ($gameServer->state() == GameServerState::Online)
            {{ __(':amount running thumbnail job(s)', ['amount' => number_format(count($gameServer->getRunningThumbnailJobs()))]) }}
        @endif
    </span>
</span>
