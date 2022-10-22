
<div>
    <div class="card card-body p-0">
        @forelse ($servers as $game_server)
            <div @class(['p-4', 'border-top' => !$loop->first]) style="transform: rotate(0) !important">
                <a class="stretched-link" href="{{ route('admin.game-server.view', $game_server->uuid) }}"></a>

                <div class="d-flex justify-content-start">
                    <div class="d-flex align-items-center me-3">
                        <i class="fa-regular fa-3x fa-server"></i>
                    </div>

                    <div class="d-flex flex-column">
                        <h4 class="mb-1">{!! __(':name <span class="text-muted fs-6">(:ip)</span>', ['name' => e($game_server->friendly_name ?? __('Unnamed')), 'ip' => e($game_server->ip_address)]) !!}</h4>

                        <div class="d-inline-flex align-items-center">
                            <x-admin::game-server.status :gameServer="$game_server" />
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <i class="text-muted p-4">{!! __('No game servers have been created yet. Why don\'t you <a href=":link">make one</a>?', ['link' => route('admin.game-server.create')]) !!}</i>
        @endforelse
    </div>

    {{ $servers->links() }}
</div>
