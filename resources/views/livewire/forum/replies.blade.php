<div>
    <div wire:loading.class="blurred">
        @foreach ($replies as $reply)
            <div id="reply-{{ $reply->id }}" class="card shadow-sm mt-3">
                <div class="d-flex justify-content-between align-items-center card-header">
                    <div>
                        <span class="text-muted mb-0"><small>{{ __('Reply') }} — {{ __('Posted at :date', ['date' => date('F j, Y, g:i a', strtotime($thread->created_at))]) }}</small></span>
                    </div>
                    <div>
                        @if ($thread->author == Auth::user() || Auth::user()->may(Forums::roleset(), Forums::GLOBAL_EDIT_POSTS))
                            <a href="#" class="btn btn-sm btn-outline-warning"><i class="fa-solid fa-pen-to-square"></i> {{ __('Edit') }}</a>
                        @endif
                        @may (Forums::roleset(), Forums::GLOBAL_DELETE_POSTS)
                            <button wire:click="delete" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash-can"></i>  {{ __('Delete') }}</button>
                        @endmay
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 border-end">
                            <div class="d-block d-md-inline-block">
                                <p class="m-0 d-inline-block"><a href="{{ route('users.profile', $reply->author->id) }}">{{ $reply->author->username }}</a></p>
                            </div>
                            <br>
                            <img src="{{ asset('img/placeholder/icon.png') }}" alt="{{ $reply->author->username }}" title="{{ $reply->author->username }}" class="img-fluid rounded-3" width="200">
                            <p class="mt-2 mb-0">Joined: <span class="text-muted">{{ date('F j Y', strtotime($reply->author->created_at)) }}</span><br>Posts: <span class="text-muted">{{ $reply->author->threads->count() + $reply->author->replies->count() }}</span></p>
                        </div>
                        <div class="col-md-10 overflow-hidden">
                            <div class="contain">
                                {{ $reply->body }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $replies->links() }}
    </div>
</div>
