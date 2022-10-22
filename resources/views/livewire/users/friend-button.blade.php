<div class="d-inline-block">
    @if (is_null($friendship))
        <button wire:click="request" wire:loading.attr="disabled" type="button" class="btn btn-primary mx-2">Send Friend Request</button>
    @elseif ($friendship->accepted)
        <button wire:click="revoke" wire:loading.attr="disabled" type="button" class="btn btn-danger mx-2">Unfriend</button>
    @elseif (Auth::user()->id == $friendship->receiver_id)
        <div class="btn-group mx-2" role="group">
            <button wire:click="accept" wire:loading.attr="disabled" type="button" class="btn btn-primary">Accept</button>
            <button wire:click="revoke" wire:loading.attr="disabled" type="button" class="btn btn-secondary">Decline</button>
        </div>
    @else
        <button type="button" class="btn btn-primary mx-2" disabled="disabled">Friend Request Pending</button>
    @endif
</div>
