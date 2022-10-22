<div>
    <div class="rounded-2 bg-lightish px-3 py-2 mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#"><a href="{{ route('forum') }}">{{ __('Forum Home') }}</a></li>
                <li class="breadcrumb-item"><a href="#"><a href="{{ route('forum.category', $thread->category->id) }}">{{ $thread->category->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $thread->title }}</li>
            </ol>
        </nav>
    </div>
    
    <div wire:loading.class="blurred">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted"><small>{{ __('Thread') }} — {{ __('Posted at :date', ['date' => date('F j, Y, g:i a', strtotime($thread->created_at))]) }}</small></span>
                </div>
                <div>
                    @may (Forums::roleset(), Forums::CREATE_REPLIES)
                        @if (!$thread->locked)
                            <a href="#" class="btn btn-sm btn-outline-success"><i class="fa-solid fa-reply"></i> {{ __('Reply') }}</a>
                        @endif
                    @endmay
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
                            <p class="m-0 d-inline-block"><a href="{{ route('users.profile', $thread->author->id) }}">{{ $thread->author->username }}</a></p>
                        </div>
                        <br>
                        <img src="{{ asset('img/placeholder/icon.png') }}" alt="{{ $thread->author->username }}" title="{{ $thread->author->username }}" class="img-fluid rounded-3" width="300">
                        <p class="mt-2 mb-0">Joined: <span class="text-muted">{{ date('F j Y', strtotime($thread->author->created_at)) }}</span><br>Posts: <span class="text-muted">{{ $thread->author->threads->count() + $thread->author->replies->count() }}</span></p>
                    </div>
                    <div class="col-md-10">
                        <div id="post-{{ $thread->id }}" class="contain">
                            {{ $thread->body }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <livewire:forum.replies :thread="$thread" />
</div>