<x-app-layout :title="__('Create Game Server')">
    <div class="container">
        <div class="rounded-2 bg-lightish px-3 py-2 mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">{{ __('Admin') }}</a></li>
                    <li class="breadcrumb-item">{{ __('Game Server Management') }}</li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Create Game Server') }}</li>
                </ol>
            </nav>
        </div>

        <h1>{{ __('Create Game Server') }}</h1>
        <p>{{ __('Only specify that a game server supports VNC if it is on SIPR. Please specify SIPR names rather than direct IP addresses.') }}</p>

        <div class="border-bottom my-3"></div>

        <livewire:admin.game-server.create />
    </div>
</x-app-layout>
