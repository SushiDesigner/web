<div>
    <div class="input-group">
        <input wire:model="search" type="text" class="form-control" placeholder="{{ __('Search') }}" aria-label="{{ __('Username') }}" aria-describedby="search-button">
        <button class="btn btn-primary" type="button" type="submit" wire:click="$refresh"><i class="fa-solid fa-search"></i></button>
    </div>

    <div class="mt-3" wire:loading.class="blurred">
        @if ($bans->total() == 0)
            <div class="text-center d-flex flex-column align-items-center my-5">
                <img src="{{ asset('img/noobs/confused.png') }}" class="img-fluid" width="200">
                <h3 class="my-2">{{ __('No results found') }}</h2>
                <p class="text-muted">{{ __('There were no matches available for your query') }}</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ __('IP Address') }}</th>
                            <th>{{ __('Identifier') }}</th>
                            <th>{{ __('Internal Reason') }}</th>
                            <th>{{ __('In Effect') }}</th>
                            <th>{{ __('Moderator') }}</th>
                            <th>{{ __('Pardoner') }}</th>
                            <th>{{ __('Reviewed On') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bans as $ban)
                            <tr>
                                <th class="fw-normal"><code>{{ $ban->ip_address }}</code></th>
                                <th class="fw-normal"><code>{{ $ban->criterium }}</code></button>
                                <th class="fw-normal">{!! is_null($ban->internal_reason) ? __('<i class="text-muted">No reason specified.</i>') : '<code>' . e($ban->internal_reason) . '</code>' !!}</code></th>
                                <th class="fw-normal">{!! ($ban->is_active ? __('<b class="text-success">Active</b>') : __('<i class="text-muted">Inactive</i>')) !!}</th>
                                <th class="fw-normal"><x-admin::mini-profile :user="$ban->moderator" /></th>
                                <th class="fw-normal"><x-admin::mini-profile :user="$ban->has_been_pardoned ? $ban->pardoner : null" /></th>
                                <th class="fw-normal">{{ $ban->created_at->format('m/d/Y') }}</th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $bans->links() }}
            </div>
        @endif
    </div>
</div>
