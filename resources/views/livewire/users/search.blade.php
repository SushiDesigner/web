<div>
    @if (empty(trim($search)))
        <h2 class="mb-3">{{ __('People') }}</h2>
    @else
        <h2 class="mb-3 text-truncate">{{ __('People Results for') }} <b>{{ $search }}</b></h2>
    @endif

    <div class="input-group">
        <input wire:model="search" type="text" class="form-control" placeholder="{{ __('Search') }}" aria-label="{{ __('Username') }}" aria-describedby="search-button">
        <button class="btn btn-primary" type="button" type="submit" wire:click="$refresh"><i class="fa-solid fa-search"></i></button>
    </div>

    <div class="mt-3" wire:loading.class="blurred">
        @if (count($users) > 0)
            <span class="text-secondary">{{ __(':from - :to of :total', ['from' => $users->firstItem(), 'to' => $users->lastItem(), 'total' => $users->total()]) }}</span>
            <div class="row row-cols-lg-3 row-cols-md-2 row-cols-1">
                @foreach ($users as $user)
                    <div class="col gy-3">
                        <div class="card card-body p-3 border-0 shadow-huh rounded-4">
                            <div class="row">
                                <div class="col col-md-4 col-sm-auto">
                                    <div class="position-relative d-inline-block h-100">
                                        <x-user.headshot :user="$user" width="100" />

                                        @if ($user->isOnline('website'))
                                            <div class="online-indicator bg-primary"><i class="fa-regular fa-user fs-5"></i></div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col col-8 ps-xxl-0 ps-xl-2 ps-sm-1 ps-0">
                                    <a class="fw-bold text-decoration-none text-dark mb-1 text-truncate h4 stretched-link d-block" href="{{ route('users.profile', $user->id) }}">{{ $user->username }}</a>

                                    @if ($user->hasChangedUsername())
                                        <span class="text-muted text-truncate d-block"><i class="fa-solid fa-clock-rotate-left me-1"></i>{{ $user->mostRecentUsername() }}</span>
                                    @endif

                                    @if ($user->isOnline('website'))
                                        <span class="text-primary">{{ __('last seen recently') }}</span>
                                    @else
                                        <span class="text-muted">{{ __('last seen :time ago', ['time' => seconds2human($user->lastSeenRelative('website'), true)]) }}</span>
                                    @endif
                                </div>
                            </div>

                            @if (Auth::user()->id != $user->id)
                                <button role="button" class="btn btn-primary btn-block text-center mt-3 w-100" data-tadah-toggle="add-friend" data-tadah-friend-recipient="{{ $user->id }}" style="z-index: 2 !important"><i class="fa-solid fa-user-plus me-1"></i>{{ __('Add Friend') }}</button>
                            @else
                                <span class="user-select-none fs-5 text-muted text-center mt-3 py-1 w-100">{{ __('This is you') }}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $users->links() }}
            </div>
        @else
            <div class="text-center d-flex flex-column align-items-center my-5">
                <img src="{{ asset('img/noobs/confused.png') }}" class="img-fluid" width="200">
                <h3 class="my-2">{{ __('No results found') }}</h2>
                <p class="text-muted">{{ __('There were no matches available for your query') }}</p>
            </div>
        @endif
    </div>
</div>
