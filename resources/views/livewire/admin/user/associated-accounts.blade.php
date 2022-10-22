<div wire:loading.class="blurred">
    @if ($accounts->total() == 0)
        <span class="text-muted">{{ __('This user does not have any alternate accounts.') }}</span>
    @else
        <div class="table-responsive">
            <table class="table table-no-collapse">
                <thead>
                    <tr>
                        <th>{{ __('User') }}</th>
                        <th width="50%">{{ __('Invite Key') }}</th>
                        <th>{{ __('Joindate') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($accounts as $account)
                        <tr>
                            <th class="fw-normal"><x-admin::mini-profile :user="$account" /></th>
                            <th class="fw-normal">{!! is_null($account->invite_key) ? '<i class="text-muted">None</i>' : '<code>' . e($account->invite_key) . '</code>' !!}</button>
                            <th class="fw-normal">{{ $account->created_at->format('m/d/Y h:i:s A (T)') }}</th>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $accounts->links() }}
        </div>
    @endif
</div>
