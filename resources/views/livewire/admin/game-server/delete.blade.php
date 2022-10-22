<div>
    <div class="modal-header">
        <h5 class="modal-title" id="usernameChangeHeader">{{ __('Delete game server') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}">
    </div>

    <form wire:submit.prevent="submit">
        @csrf

        <div class="modal-body">
            <p class="mb-0">
                {!! __('Are you <b>absolutely sure</b> you want to delete this game server?') !!}
            </p>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('No, take me back') }}</button>
            <button type="submit" class="btn btn-danger">{{ __('Yes, I\'m sure') }}</button>
        </div>
    </form>
</div>
