<x-app-layout :title="__('IP Ban User')">
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
                    <li class="breadcrumb-item active" aria-current="page">{{ __('IP Ban') }}</li>
                </ol>
            </nav>
        </div>

        <h1>{{ __('IP Ban User') }}</h1>
        <p>{{ __('IP bans a user. They cannot access the website whatsoever once an IP ban is in effect. IP bans do not expire-- you must manually pardon a user. If you specify an e-mail address, all accounts with that email will have their IP banned.') }}
        <div class="border-bottom my-3"></div>

        <ul class="nav nav-tabs floating-nav-tabs" role="tab-list">
            <li class="nav-item">
                <a class="nav-link floating-tab active" data-bs-toggle="tab" role="tab" aria-selected="true" aria-current="page" href="#ban">{{ __('Ban') }}</a>
            </li>

            <li class="nav-item">
                <a @class(['nav-link floating-tab', 'disabled' => !auth()->user()->may(Users::roleset(), Users::MODERATION_PARDON_IP_ADDRESS_BAN)]) data-bs-toggle="tab" role="tab" aria-current="page" href="#pardon">{{ __('Pardon') }}</a>
            </li>

            <li class="nav-item">
                <a @class(['nav-link floating-tab', 'disabled' => !auth()->user()->may(Users::roleset(), Users::MODERATION_VIEW_IP_ADDRESS_BAN_LIST)]) data-bs-toggle="tab" role="tab" aria-current="page" href="#list">{{ __('Search') }}</a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane floating-tab-page start show active" role="tabpanel" aria-labelledby="ban" id="ban">
                <livewire:admin.ban.ip-address />
            </div>

            @may (Users::roleset(), Users::MODERATION_PARDON_IP_ADDRESS_BAN)
                <div class="tab-pane floating-tab-page" role="tabpanel" aria-labelledby="pardon" id="pardon">
                    <livewire:admin.ban.pardon-ip-address />
                </div>
            @endmay

            @may (Users::roleset(), Users::MODERATION_VIEW_IP_ADDRESS_BAN_LIST)
                <div class="tab-pane floating-tab-page" role="tabpanel" aria-labelledby="list" id="list">
                    <livewire:admin.ban.ip-address-search />
                </div>
            @endmay
        </div>
    </div>
</x-app-layout>
