<x-app-layout :title="$user->username">
    <div class="container" style="max-width: 970px">
        <div class="row gx-0 row-cols-md-2 row-cols-1">
            <div class="col border-md-end pe-0">
                <div class="border-bottom px-0 pe-md-3 pb-3">
                    <h2>{{ Auth::user()->id == $user->id ?  __('Your Profile') :  __(':username\'s Profile', ['username' => $user->username]) }}</h2>
                    <div class="text-center">
                        @if ($user->isOnline('website'))
                            <p class="text-primary">[ Online: Website ]</p>
                        @else
                            <p class="text-secondary">[ Offline ]</p>
                        @endif
                        <img src="{{ asset('img/placeholder/icon.png') }}" alt="{{ $user->username }}" title="{{ $user->username }}" class="img-fluid rounded-3" width="300">
                        <p class="mt-3">{{ $user->blurb }}</p>
                        @if (Auth::user()->id != $user->id)
                            <div class="mt-3">
                                <button type="button" class="btn btn-primary mx-2">Send Message</button>
                                <livewire:users.friend-button :user="$user" />
                            </div>
                        @endif
                    </div>
                </div>
                <div class="border-bottom px-0 pe-md-3 py-3">
                    <h3>{{ __('Badges') }}</h3>
                    <div class="text-center py-3" id="data-loading">
                        <div role="status" class="spinner-border text-center text-secondary">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="border-bottom px-0 pe-md-3 py-3">
                    <h3>{{ __('Groups') }}</h3>
                    <div class="text-center py-3" id="data-loading">
                        <div role="status" class="spinner-border text-center text-secondary">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="border-bottom px-0 pe-md-3 py-3">
                    <h3>{{ __('Statistics') }}</h3>
                    <div class="row cols-2 gx-2 text-center">
                        <div class="col text-end">
                            <acronym style="cursor: help" title="{{ __('The date this user made their :project account.', ['project' => config('app.name')]) }}">{{ __('Joined:') }}</acronym>
                        </div>
                        <div class="col text-start">
                            <p class="mb-0">{{ date('F j Y', strtotime($user->created_at)); }}</p>
                        </div>
                    </div>
                </div>
                <div class="border-xs-bottom border-sm-bottom border-md-bottom-0 border-bottom-none px-0 pe-md-3 py-3">
                    <h3>{{ __('Sets') }}</h3>
                    <div class="text-center py-3" id="data-loading">
                        <div role="status" class="spinner-border text-center text-secondary">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col ps-0">
                <div class="border-bottom px-0 ps-md-3 py-3 pt-md-0">
                    <h3>{{ __('Places') }}</h3>
                    <div class="text-center py-3" id="data-loading">
                        <div role="status" class="spinner-border text-center text-secondary">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="border-bottom px-0 ps-md-3 py-3">
                    <div class="d-flex justify-content-between mb-2">
                        <h3 class="mb-0">{{ __('Friends') }}</h3>
                        <div class="d-flex align-items-center">
                            @if (Auth::user()->id == $user->id)
                                <a class="btn btn-primary btn-sm"><i class="fa-solid fa-pencil me-1"></i>{{ __('Edit') }}</a>
                            @elseif ($num_friends > 0)
                                <a class="btn btn-primary btn-sm">{{ __('See all :num_friends', compact('num_friends')) }}</a>
                            @endif
                        </div>
                    </div>
                    <div class="text-center py-3" id="data-loading">
                        <div role="status" class="spinner-border text-center text-secondary">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="border-bottom px-0 ps-md-3 py-3">
                    <div class="d-flex justify-content-between mb-2">
                        <h3 class="mb-0">{{ __('Favorites') }}</h3>
                        <div class="d-flex align-items-center">
                            <select class="form-select form-select-sm">
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-center py-3" id="data-loading">
                        <div role="status" class="spinner-border text-center text-secondary">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="text-center px-0 ps-md-3 py-3">
                    <h3>{{ __('[insert ad]') }}</h3>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
