<x-app-layout :title="__('Game Servers')">
    <div class="container">
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible mb-4 shadow-sm fade show" role="alert">
                {!! session()->get('success') !!}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
            </div>
        @endif

        <div class="rounded-2 bg-lightish px-3 py-2 mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">{{ __('Admin') }}</a></li>
                    <li class="breadcrumb-item">{{ __('Game Server Management') }}</li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Game Server List') }}</li>
                </ol>
            </nav>
        </div>

        <h1>{{ __('Game Servers') }}</h1>
        <div class="border-bottom my-3"></div>

        <livewire:admin.game-server.all :gameServers="\App\Models\GameServer::all()" />
    </div>
</x-app-layout>
