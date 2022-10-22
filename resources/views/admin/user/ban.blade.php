<x-app-layout :title="__('Ban User')">
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
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Ban') }}</li>
                </ol>
            </nav>
        </div>

        <h1>{{ __('Ban User') }}</h1>
        <p>{{ __('Bans a user, either temporarily or permanently. You may also unban users.') }}</p>

        <div class="border-bottom my-3"></div>

        <ul class="nav nav-tabs floating-nav-tabs" role="tab-list">
            <li class="nav-item">
                <a class="nav-link floating-tab active" data-bs-toggle="tab" role="tab" aria-current="page" aria-selected="true" href="#ban">{{ __('Ban') }}</a>
            </li>
            <li class="nav-item">
                <a @class(['nav-link floating-tab', 'disabled' => !auth()->user()->may(Users::roleset(), Users::MODERATION_GENERAL_BAN)]) data-bs-toggle="tab" role="tab" aria-current="page" href="#pardon">{{ __('Pardon') }}</a>
            </li>
            <li class="nav-item">
                <a @class(['nav-link floating-tab', 'disabled' => !auth()->user()->may(Users::roleset(), Users::MODERATION_VIEW_BAN_LIST)]) data-bs-toggle="tab" role="tab" aria-current="page" href="#list">{{ __('Search') }}</a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane floating-tab-page start show active" role="tabpanel" aria-labelledby="ban" id="ban">
                <livewire:admin.ban.user />
            </div>

            @may (Users::roleset(), Users::MODERATION_PARDON_BAN)
                <div class="tab-pane floating-tab-page" role="tabpanel" aria-labelledby="pardon" id="pardon">
                    <livewire:admin.ban.pardon />
                </div>
            @endmay

            @may (Users::roleset(), Users::MODERATION_VIEW_BAN_LIST)
                <div class="tab-pane floating-tab-page" role="tabpanel" aria-labelledby="list" id="list">
                    <livewire:admin.ban.search />
                </div>
            @endmay
        </div>

        @may (Users::roleset(), Users::MODERATION_VIEW_BAN_LIST)
            <div class="modal fade" id="banDetailsModal" tabindex="-1" aria-labelledby="banDetailsModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="banDetailsModalLabel">{{ __('Ban Details') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
                        </div>

                        <div class="modal-body">
                            <div id="loading" class="my-3">
                                <div class="d-flex flex-column align-items-center h-100">
                                    <img src="{{ asset('img/noobs/status/building.gif') }}" width="75">
                                    <span class="text-muted mt-3">{{ __('Just a moment...') }}</span>
                                </div>
                            </div>

                            <div id="content" style="display: none">
                                <span id="moderator_note"><b class="me-1">{{ __('Moderator Note:') }}</b> <code></code></span>
                                <br>
                                <span id="internal_reason"><b class="me-1">{{ __('Internal Reason:') }}</b> <code></code></span>
                                <br>
                                <span id="is_appealable"><b>{{ __('Is Appealable?') }}</b> <span></span></span>
                                <br>
                                <div id="offensive_item">
                                    <br>
                                    <b>{{ __('Offensive Item:') }}</b>
                                    <div class="card card-body mt-2 offensive-item">
                                    </div>
                                </div>
                                <span id="pardon_reason"><b class="me-1">{{ __('Pardon Reason:') }}</b> <code></code></span>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        @endmay
    </div>
</x-app-layout>
