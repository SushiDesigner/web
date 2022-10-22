<div wire:loading.class="blurred">
    @if ($bans->total() == 0)
        <span class="text-muted">{{ __('This user has not had moderation action taken against them in the past.') }}</span>
    @else
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th width="55%">{{ __('Moderator note') }}</th>
                        <th>{{ __('Reviewed on') }}</th>
                        <th>{{ __('Expiry date') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bans as $ban)
                        <tr>
                            <td><code>{{ $ban->moderator_note }}</code></td>
                            <td>{{ $ban->created_at->format('m/d/Y h:i:s A (T)') }}</td>
                            <td>{{ is_null($ban->expiry_date) ? ($ban->is_poison_ban ? __('Poison') : ($ban->is_warning ? __('Warning') : __('Termination') )) : collapseSeconds($ban->expiry_date->timestamp - $ban->created_at->timestamp) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $bans->links() }}
        </div>
    @endif
</div>
