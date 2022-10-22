<x-app-layout :title="__('My Account')">
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success alert-dismissible my-3 shadow-sm fade show" role="alert">
                @if (session('status') == 'two-factor-authentication-enabled')
                    {{ __('Two factor authentication successfully enabled! Please scan your QR code and keep note of your recovery codes.') }}
                @else
                    {!! session('status') !!}
                @endif
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
            </div>
        @endif

        <div class="w-100 d-flex justify-content-start">
            <img class="rounded-circle me-3" src="{{ asset('img/placeholder/icon.png') }}" width="48">
            <div>
                <a class="text-decoration-hover text-dark fw-bold" href="{{ route('users.profile', Auth::user()->id) }}">{{ Auth::user()->username }}</a>
                <br>
                <span class="text-muted text-small">
                    <i class="fa-duotone fa-dash me-1"></i>{{ config('tadah.currency_name') }}
                    <span class="mx-2">|</span><i class="fa-duotone fa-dash me-1"></i>{{ __('friends') }}
                    <span class="mx-2">|</span><i class="fa-duotone fa-dash me-1"></i>{{ __('visits') }}
                </span>
            </div>
        </div>
        <div class="my-3 border-bottom"></div>
        <div class="row row-cols-md-2 row-cols-1">
            <div class="col col-xl-2 col-lg-3 col-md-3 mb-md-0 mb-3 border-md-end border-sm-end-0">
                <div class="nav flex-column nav-pills" id="pills-tab" role="tab-list" aria-orientation="vertical">
                    <a class="nav-link active small-pill mb-1" data-bs-toggle="tab" role="tab" aria-selected="true" href="#profile" aria-controls="profile">
                        <i class="fa-regular fa-fw fa-user me-1"></i>{{ __('Profile')}}
                    </a>

                    <a class="nav-link small-pill mb-1" data-bs-toggle="tab" role="tab" href="#account" aria-controls="account">
                        <i class="fa-regular fa-fw fa-gear me-1"></i>{{ __('Account')}}
                    </a>

                    <a class="nav-link small-pill mb-1" data-bs-toggle="tab" role="tab" href="#appearance" aria-controls="appearance">
                        <i class="fa-regular fa-paintbrush fa-fw me-1"></i>{{ __('Appearance')}}
                    </a>

                    <a class="nav-link small-pill mb-1" data-bs-toggle="tab" role="tab" href="#security" aria-controls="security">
                        <i class="fa-regular fa-shield-blank fa-fw me-1"></i>{{ __('Security')}}
                    </a>

                    @may (Users::roleset(), Users::VIEW_BAN_HISTORY)
                        <a class="nav-link small-pill mb-1" data-bs-toggle="tab" role="tab" href="#moderation-history" aria-controls="moderation-history">
                            <i class="fa-regular fa-book fa-fw me-1"></i>{{ __('Moderation History')}}
                        </a>
                    @endmay
                </div>
            </div>

            <div class="col col-xl-10 col-lg-9 col-md-9">
                <div class="ps-2 pt-2 pb-3 pe-3 pt-md-2 pt-3 border-md-top-0 border-sm-top border-xs-top">
                    <div class="tab-content" id="tab-listContent">
                        <div class="tab-pane fade show active" role="tabpanel" id="profile" aria-labelledby="profile-tab">
                            <h4>{{ __('Profile Information') }}</h4>
                            <span>{{ __('Update your profile information and email address.') }}</span>
                            <div class="card mt-3">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label" for="username">{{ __('Username') }}</label>
                                        <input class="form-control" type="text" name="username" value="{{ Auth::user()->username }}" id="usernameChange">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="email">{{ __('Email') }}</label>
                                        <input class="form-control" type="text" name="email" value="builderman@gmail.com" id="emailChange">
                                    </div>

                                    <livewire:account.update-blurb />
                                </div>
                            </div>

                            @if (config('tadah.discord_required'))
                                <div class="border-bottom my-3"></div>

                                <h4>{{ __('Link Discord Account') }}</h4>
                                <span>{{ __('Link your Discord account to :project to access additional features.', ['project' => config('app.name')]) }}</span>
                                <div class="card mt-3">
                                    <div class="card-body">
                                        @isset ($discord_user)
                                            <div class="p-1 d-flex align-items-center justify-content-start">
                                                <img class="rounded-circle" src="{{ $discord_user->avatarUrl }}" height="100">

                                                <div class="ms-3">
                                                    <h3 class="mb-1">{{ $discord_user->username }}<span class="text-muted">#{{ $discord_user->discriminator }}</span></h3>
                                                    <h5 class="text-muted mb-2">{{ __('Account linked on :date', ['date' => Auth::user()->discord_linked_at->format('M d, Y')]) }}</h5>
                                                    <span class="small-text text-muted font-monospace">{{ $discord_user->id }}</span>
                                                </div>

                                                <div class="ms-auto me-2">
                                                    <form method="post" action="{{ route('account.discord.unlink') }}">
                                                        @csrf
                                                        <a class="text-muted tadah-link-submit" href="#">{{ __('Unlink') }}</a>
                                                    </form>
                                                </div>
                                            </div>
                                        @else
                                            <h3>{{ __('You have not linked a Discord account.') }}</h3>
                                            <p>{{ __('By linking a Discord account, you will be able to play games on :project, be automatically verified on the :project Discord, post on the forums, add friends, and participate in the :project economy.', ['project' => config('app.name')]) }}</p>
                                            <a href="{{ route('account.discord.redirect') }}" class="btn btn-primary" role="button">{{ __('Connect Discord Account') }}</a>
                                        @endisset
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="tab-pane fade" role="tabpanel" id="account" aria-labelledby="account-tab">
                            <h4>{{ __('Update Password') }}</h4>
                            <span>{{ __('Ensure your account is using a long, random password to stay secure.') }}</span>
                            <livewire:account.update-password />
                        </div>

                        <div class="tab-pane fade" role="tabpanel" id="appearance" aria-labelledby="appearance-tab">
                            TODO
                        </div>

                        <div class="tab-pane fade" role="tabpanel" id="security" aria-labelledby="security-tab">
                            <h4>{{ __('Two Factor Authentication') }}</h4>
                            <span>{{ __('Add additional security to your account using two factor authentication.') }}</span>
                            <div>
                                <div class="card mt-3">
                                    <div class="card-body">
                                        @if (Auth::user()->two_factor_secret)
                                            <h3>{{ __('Two factor authentication is enabled!') }}</h3>
                                        @else
                                            <h3>{{ __('Two factor authentication is disabled.') }}</h3>
                                        @endif
                                        <p>{{ __('Two factor authentication requires you to take an extra step when logging in to your :project account. Some actions on :project may require you to have two factor authentication enabled.', ['project' => config('app.name')]) }}</p>

                                        <div>
                                            @if (Auth::user()->two_factor_secret)
                                                <button style="display: inline-block;" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#twoFactorModal">
                                                    {{ __('View codes') }}
                                                </button>
                                                <form style="display: inline-block;" action="{{ route('two-factor.disable') }}" value="DELETE">@csrf <button type="submit" class="btn btn-danger">{{ __('Disable') }}</button></form>
                                            @else
                                                <form action="{{ route('two-factor.enable') }}" method="POST">@csrf <button type="submit" class="btn btn-primary">{{ __('Enable') }}</button></form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="border-bottom my-3"></div>

                            <h4>{{ __('Sessions') }}</h4>
                            <span>{{ __('This is a list of devices that have logged into your account. Revoke any sessions that you do not recognize.') }}</span>
                            <div class="card mt-3" id="sessions">
                                <div class="card-body p-0">
                                    <x-account::session :agent="$current_session->agent" :ip="$current_session->ip" :location="$current_session->location" :ping="$current_session->last_ping" />

                                    @foreach ($sessions as $session)
                                        <x-account::session :key="$session->key" :agent="$session->agent" :ip="$session->ip" :location="$session->location" :ping="$session->last_ping" :revokable="true" />
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        @may (Users::roleset(), Users::VIEW_BAN_HISTORY)
                            <div class="tab-pane fade" role="tabpanel" id="moderation-history" aria-labelledby="moderation-history-tab">
                                <livewire:account.moderation-history />
                            </div>
                        @endmay
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="usernameChangeModal" tabindex="-1" aria-labelledby="usernameChangeHeader" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <livewire:account.update-username />
                </div>
            </div>
        </div>

        @if (Auth::user()->two_factor_secret)
            <div class="modal fade" id="twoFactorModal" tabindex="-1" aria-labelledby="twoFactorHeader" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="usernameChangeHeader">{{ __('Two factor authentication') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}">
                        </div>

                        <div class="modal-body">
                            <div class="text-center">
                                <p class="mb-1">{{ __('QR Code') }}</p>
                                {!! Auth::user()->twoFactorQrCodeSvg() !!}
                                <hr>
                                <p class="mb-0">{{ __('Recovery codes') }}</p>
                                <ul class="list-group">
                                    @foreach (Auth::user()->recoveryCodes() as $code)
                                        <li><code>{{ $code }}</code></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
