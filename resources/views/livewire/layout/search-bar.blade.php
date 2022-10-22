<div>
    <div class="position-relative">
        <div class="input-group input-group-sm">
            <input wire:model="search" class="searchbar form-control" type="text" placeholder="{{ __('Search') }}" aria-label="{{ __('Search') }}">
        </div>
        @if (!empty($search))
            <div class="w-100 autocomplete-search mt-1 position-absolute bg-white border border-gray-300 rounded shadow-lg">
                @if ($users->count() > 0)
                    <div wire:loading.class="blurred">
                        @foreach ($users as $user)
                            <div style="transform: rotate(0);" class="search-result border-bottom px-2 py-2">
                                <div class="row">
                                    <div class="col-auto d-flex align-items-center">
                                        <div class="position-relative d-inline-block h-100">
                                            <x-user.headshot :user="$user" width="48" />

                                            @if ($user->isOnline('website'))
                                                <div class="online-indicator-sm bg-primary"><i class="fa-regular fa-user fa-xs"></i></div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-auto align-self-center p-0">
                                        <div class="d-flex flex-column">
                                            <a class="stretched-link fw-bold text-decoration-none text-dark text-truncate d-block" href="{{ route('users.profile', $user->id) }}">
                                                {{ $user->username }}
                                            </a>

                                            @if ($user->id == auth()->user()->id)
                                                <small class="text-muted">{{ __('This is you') }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div style="transform: rotate(0);" class="search-result border-bottom p-3 py-3 rounded">
                    <a class="stretched-link text-decoration-none text-secondary" href="{{ route('users', ['search' => $search]) }}">
                        <i class="fa-regular fa-user me-2"></i>
                        {!! __('<strong>:query</strong> in People', ['query' => e($search)]) !!}
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
