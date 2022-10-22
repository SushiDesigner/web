<x-app-layout :title="$game_server->friendly_name ?? __('Viewing Game Server')" :data="$data">
    <div class="container">
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible shadow-sm fade show">
                {!! session()->get('success') !!}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
            </div>
        @endif

        <div class="rounded-2 bg-lightish px-3 py-2 mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">{{ __('Admin') }}</a></li>
                    <li class="breadcrumb-item">{{ __('Game Server Management') }}</li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.game-server.view', $game_server->uuid) }}">{{ $gameServer->friendly_name ?? __('Unnamed') }}</a></li>
                </ol>
            </nav>
        </div>

        <x-admin::game-server.topbar :gameServer="$game_server" />

        @if (!$game_server->is_set_up)
            <div class="card">
                <div class="card-header">{{ __('Finish Setting Up') }}</div>
                <div class="card-body">
                    <p class="mb-0">
                        {!! __('In order to finish setting up this game server, please open up the Tadah.Arbiter\'s <code>App.config</code> and add the following access key like so:') !!}
                    </p>

                    <x-admin::game-server.syntax :key="$game_server->access_key" />

                    <p class="mb-0">
                        {{ __('Then, launch Tadah.Arbiter. Upon a successful connection, you will see this page automatically reload.') }}
                    </p>
                </div>
            </div>
        @else
            <ul class="nav nav-tabs" id="gameServerTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab" aria-controls="overview" aria-selected="true">{{ __('Overview') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="jobs-tab" data-bs-toggle="tab" data-bs-target="#jobs" type="button" role="tab" aria-controls="jobs" aria-selected="false">{{ __('Jobs') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab" aria-controls="history" aria-selected="false">{{ __('History') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="console-tab" data-bs-toggle="tab" data-bs-target="#console" type="button" role="tab" aria-controls="console" aria-selected="false">{{ __('Console') }}</a>
                </li>
            </ul>

            <div class="tab-content mt-3" id="gameServerTabContent">
                <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                    <div class="card card-body mb-3">
                        <pre class="arbiter-output offline-output mb-0">
                            <img src="{{ asset('img/dead.png') }}" width="128" height="128" @class(['dead-image', 'd-none' => $game_server->state() != GameServerState::Offline])>
                            <div @class(['spinner-border loading-output-spinner', 'd-none' => $game_server->state() == GameServerState::Offline]) role="status">
                                <span class="visually-hidden">{{ __('Loading Game Server Console...') }}</span>
                            </div>

                            <div id="content" class="d-flex flex-column d-none"></div>
                        </pre>

                        <span class="text-muted mt-2 d-none" id="timestamp">
                            {{ __('Note: Timestamps are set in') }} <span id="offset" class="font-monospace">UTC{{ substr($game_server->utc_offset, 0, -3) }}</span>
                        </span>
                    </div>

                    <div class="row row-cols-md-2 row-cols-1 mb-3">
                        <div class="col">
                            <h2>{{ __('CPU Usage') }}</h2>
                            <div class="card card-body">
                                <canvas class="d-none" id="cpu-usage"></canvas>
                                <i class="text-muted">{{ __('CPU usage statistics are unavailable while the game server is offline.') }}</i>
                            </div>
                        </div>

                        <div class="col mt-md-0 mt-3">
                            <h2>{{ __('RAM Usage') }}</h2>
                            <div class="card card-body">
                                <canvas class="d-none" id="ram-usage"></canvas>
                                <i class="text-muted">{{ __('RAM usage statistics are unavailable while the game server is offline.') }}</i>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <h2>{{ __('Network Usage') }}</h2>
                        <div class="card card-body">
                            <canvas class="d-none" id="network-usage"></canvas>
                            <i class="text-muted">{{ __('Network Usage statistics are unavailable while the game server is offline.') }}</i>
                        </div>
                    </div>

                    <a href="http://analytics.sipr.tadah.rocks/" id="grafana" class="d-none">{{ __('View more statistics on Grafana') }}</a>
                </div>

                <div class="tab-pane fade" id="jobs" role="tabpanel" aria-labelledby="jobs-tab">...</div>
                <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">...</div>
                <div class="tab-pane fade" id="console" role="tabpanel" aria-labelledby="console-tab">...</div>
            </div>
        @endif
    </div>
</x-app-layout>
