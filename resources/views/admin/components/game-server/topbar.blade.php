@may (GameServers::roleset(), GameServers::VIEW_VNC)
    @if ($gameServer->has_vnc)
        <div class="modal fade" id="vncModal" tabindex="-1" aria-labelledby="vncModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="vncModalLabel">{{ __('VNC Connection Information') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
                    </div>

                    <div class="modal-body">
                        <p>
                            {!! __('We recommend you use <a href=":link">TightVNC</a> as your VNC viewer.', ['link' => 'https://www.tightvnc.com/']) !!}
                        </p>

                        <div @class(['mb-3' => !is_null($gameServer->vnc_password)])>
                            <label class="form-label" for="connection">{{ __('IP Address & Port') }}</label>

                            <div class="input-group">
                                <input type="text" class="form-control" x-model="connection" id="connection" value="{{ sprintf('%s:%d', $gameServer->ip_address, $gameServer->vnc_port) }}" disabled>
                                <button class="btn btn-dark" type="button" tabindex="-1" @@click="$clipboard(connection)"><i class="fa-solid fa-copy"></i></button>
                            </div>
                        </div>

                        @if (!is_null($gameServer->vnc_password))
                            <div>
                                <label class="form-label" for="password">{{ __('Password') }}</label>

                                <div class="input-group">
                                    <input type="text" class="form-control" x-model="password" id="password" value="{{ $gameServer->vnc_password }}" disabled>
                                    <button class="btn btn-dark" type="button" @@click="$clipboard(password)" tabindex="-1"><i class="fa-solid fa-copy"></i></button>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endmay

@may (GameServers::roleset(), GameServers::DELETION)
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteHeader" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <livewire:admin.game-server.delete :gameServer="$gameServer" />
            </div>
        </div>
    </div>
@endmay

<div class="row row-cols-sm-2 row-cols-1">
    <div class="col">
        <h1 class="mb-0">{!! __('<span id="friendly_name">:name</span> <span class="text-muted fs-4">(:ip)</span>', ['name' => e($gameServer->friendly_name ?? __('Unnamed')), 'ip' => e($gameServer->ip_address)]) !!}</h1>
    </div>

    <div class="d-flex align-items-center justify-content-end col my-sm-0 mb-1 mt-2">
        <div class="btn-group w-sm-auto w-xs-100" role="group" aria-label="{{ __('Game Server Management') }}">
            @may (GameServers::roleset(), GameServers::CONNECT)
                <button class="btn btn-outline-secondary" @disabled($gameServer->state() != GameServerState::Online) type="button" id="shutdown">
                    <i class="fa-solid fa-power-off fa-fw"></i>
                </button>

                <button class="btn btn-outline-secondary" @disabled($gameServer->state() != GameServerState::Online) type="button" id="sleep">
                    <i class="fa-solid fa-moon fa-fw"></i>
                </button>
            @endmay

            @may (GameServers::roleset(), GameServers::VIEW_VNC)
                @if ($gameServer->has_vnc)
                    <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal" data-bs-target="#vncModal">
                        <i class="fa-solid fa-computer-classic fa-fw"></i>
                    </button>
                @endif
            @endmay

            @may (GameServers::roleset(), GameServers::DELETION)
                <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    <i class="fa-solid fa-trash-can fa-fw"></i>
                </button>
            @endmay

            @may (GameServers::roleset(), GameServers::MANAGE)
                <a class="btn btn-outline-secondary" href="{{ route('admin.game-server.manage', $gameServer->uuid) }}" type="button">
                    <i class="fa-solid fa-wrench"></i>
                </a>
            @endmay
        </div>
    </div>
</div>

<div class="mb-3 mt-1 d-flex">
    <x-admin::game-server.status :gameServer="$gameServer" />
</div>
