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
                            <th width="20%">{{ __('User') }}</th>
                            <th>{{ __('Details') }}</th>
                            <th>{{ __('In Effect') }}</th>
                            <th width="20%">{{ __('Moderator') }}</th>
                            <th width="20%">{{ __('Pardoner') }}</th>
                            <th>{{ __('Reviewed On') }}</th>
                            <th>{{ __('Duration') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bans as $ban)
                            <tr>
                                <th class="fw-normal"><x-admin::mini-profile :user="$ban->user" /></th>
                                <th class="fw-normal"><button type="button" class="btn btn-primary btn-sm" data-tadah-ban-id="{{ $ban->id }}"><i class="fa-solid fa-eye me-1"></i>{{ __('View') }}</button>
                                <th class="fw-normal">{!! ($ban->is_active ? __('<b class="text-success">Active</b>') : __('<i class="text-muted">Inactive</i>')) !!}</th>
                                <th class="fw-normal"><x-admin::mini-profile :user="$ban->moderator" /></th>
                                <th class="fw-normal"><x-admin::mini-profile :user="$ban->has_been_pardoned ? $ban->pardoner : null" /></th>
                                <th class="fw-normal">{{ $ban->created_at->format('m/d/Y') }}</th>
                                <th class="fw-normal">{{ is_null($ban->expiry_date) ? ($ban->is_poison_ban ? __('Poison') : ($ban->is_warning ? __('Warning') : __('Termination') )) : seconds2human($ban->expiry_date->timestamp - $ban->created_at->timestamp, true) }}</th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $bans->links() }}
            </div>
        @endif
    </div>
</div>
