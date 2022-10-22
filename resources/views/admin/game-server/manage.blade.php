<x-app-layout :title="__('Managing :name', ['name' => $game_server->friendly_name ?? __('Unnamed')])">
    <div class="container">
        <div class="rounded-2 bg-lightish px-3 py-2 mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">{{ __('Admin') }}</a></li>
                    <li class="breadcrumb-item">{{ __('Game Server Management') }}</li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.game-server.view', $game_server->uuid) }}">{{ $gameServer->friendly_name ?? __('Unnamed') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Manage') }}</li>
                </ol>
            </nav>
        </div>

        <x-admin::game-server.topbar :gameServer="$game_server" />
        <livewire:admin.game-server.manage :gameServer="$game_server" />
    </div>
</x-app-layout>
