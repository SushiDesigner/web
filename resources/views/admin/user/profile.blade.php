<x-app-layout :title="__('User Profile')">
    <div class="container">
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible shadow-sm fade show">
                {!! session()->get('success') !!}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible shadow-sm fade show">
                {!! session()->get('error') !!}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
            </div>
        @endif

        <div class="rounded-2 bg-lightish px-3 py-2 mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">{{ __('Admin') }}</a></li>
                    <li class="breadcrumb-item">{{ __('User Moderation') }}</li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('User Profile') }}</li>
                </ol>
            </nav>
        </div>

        <h1 class="fw-bold">{{ __('User Profile') }}</h1>
        <p>{{ __('An in-depth view of a user.') }}

        <div class="border-bottom my-3"></div>

        @isset ($user)
            <ul class="nav nav-tabs floating-nav-tabs" role="tab-list">
                <li class="nav-item">
                    <a class="nav-link floating-tab active" data-bs-toggle="tab" role="tab" aria-selected="true" aria-current="page" href="#profile">{{ __(':username\'s Profile', ['username' => $user->username]) }}</a>
                </li>

                <li class="nav-item">
                    <a @class(['nav-link floating-tab', 'disabled' => !auth()->user()->may(Users::roleset(), Users::MODERATION_VIEW_BAN_HISTORY)]) data-bs-toggle="tab" role="tab" aria-current="page" href="#history">{{ __('Moderation History') }}</a>
                </li>

                <li class="nav-item">
                    <a @class(['nav-link floating-tab', 'disabled' => !auth()->user()->may(Users::roleset(), Users::MODERATION_VIEW_ASSOCIATED_ACCOUNTS)]) data-bs-toggle="tab" role="tab" aria-current="page" href="#associated">{{ __('Associated Accounts') }}</a>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane floating-tab-page start show active" role="tabpanel" aria-labelledby="profile" id="profile">
                    <div class="row">
                        <div class="col-auto">
                            <img src="{{ asset('img/placeholder/icon.png') }}" alt="{{ $user->username }}" title="{{ $user->username }}" class="img-fluid rounded-3" width="200">
                        </div>
                        <div class="col-auto">
                            <p class="mb-0">
                                {{ __('E-Mail') }}: <code>{{ $user->email }}</code>
                                <br>
                                {{ __('Last IP') }}: <code>{{ $user->register_ip }}</code>
                                <br>
                                {{ __('Register IP') }}: <code>{{ $user->last_ip }}</code>
                                <br>
                                {{ __('Discord ID') }}: @if ($user->hasLinkedDiscordAccount()) {{ $user->discord_id }} @else {!! __('<i class="text-muted">None</i>') !!} @endif
                                <br>
                                {{ __('2FA') }}: {{ ($user->two_factor_confirmed ? __('Enabled') : __('Disabled')) }}
                                <br>
                                {{ __('Banned') }}: {{ ($user->isBanned() ? __('Yes') : __('No')) }}
                                <br>
                                {{ __('Joindate') }}: <code>{{ $user->created_at->format('m/d/Y h:i:s A (T)') }}</code>
                            </p>
                        </div>
                    </div>
                </div>

                @may (Users::roleset(), Users::MODERATION_PARDON_IP_ADDRESS_BAN)
                    <div class="tab-pane floating-tab-page" role="tabpanel" aria-labelledby="history" id="history">
                        <livewire:admin.user.moderation-history :user="$user" />
                    </div>
                @endmay

                @may (Users::roleset(), Users::MODERATION_VIEW_IP_ADDRESS_BAN_LIST)
                    <div class="tab-pane floating-tab-page" role="tabpanel" aria-labelledby="associated" id="associated">
                        <livewire:admin.user.associated-accounts :accounts="$user->getAssociatedAccounts()" />
                    </div>
                @endmay
            </div>
        @else
            <div class="card">
                <div class="card-header">{{ __('User Profile') }}</div>
                <div class="card-body">
                    <form method="post" action="{{ route('admin.user.profile') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label" for="username">{{ __('Username') }}</label>
                            <input class="form-control" name="username" id="username" required>
                        </div>

                        <button class="btn btn-primary" type="submit"><i class="fa-solid fa-id-card me-1"></i>{{ __('Load User Profile') }}</button>
                    </form>
                </div>
            </div>
        @endisset

    </div>
</x-app-layout>
