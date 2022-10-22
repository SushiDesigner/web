<div>
    <div class="input-group">
        <input wire:model="search" type="text" class="form-control" placeholder="{{ __('Search') }}" aria-label="{{ __('Username') }}" aria-describedby="search-button">
        <button class="btn btn-primary" type="button" type="submit" wire:click="$refresh"><i class="fa-solid fa-search"></i></button>
    </div>

    <div class="mt-3" wire:loading.class="blurred">
        @if ($logs->total() == 0)
            <div class="text-center d-flex flex-column align-items-center my-5">
                <img src="{{ asset('img/noobs/confused.png') }}" class="img-fluid" width="200">
                <h3 class="my-2">{{ __('No records found') }}</h2>
                <p class="text-muted">{{ __('There were no matches available for your query') }}</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="20%">{{ __('Administrator') }}</th>
                            <th>{{ __('Action') }}</th>
                            <th width="20%">{{ __('Date') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $log)
                            <tr>
                                <th class="fw-normal"><x-admin::mini-profile :user="$log->doer" /></th>
                                <th class="fw-normal">{{ $log->format() }}</th>
                                <th class="fw-normal">{{ date('M d, Y g:i:s A', strtotime($log->created_at)) }}</th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $logs->links() }}
            </div>
        @endif
    </div>
</div>
