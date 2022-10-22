<div>
    <div class="card" wire:loading.class="blurred">
        @if ($threads->total() == 0)
            <div class="text-center d-flex flex-column align-items-center my-5">
                <img src="{{ asset('img/noobs/confused.png') }}" class="img-fluid" width="200">
                <h3 class="my-2">{{ __('No threads found') }}</h2>
            </div>
        @else
            <ul class="list-group list-group-flush">
                @foreach ($threads as $thread)
                <li class="list-group-item forum-thread">
                    <a class="text-decoration-none text-reset" href="{{ route('forum.thread', $thread->id) }}">
                        <p class="text-truncate mb-0">
                            {{ $thread->title }}
                            @if (!$category)
                                <span style="background-color: {{ $thread->category->color }};" class="ms-1 rounded-pill badge">{{ $thread->category->name }}</span>
                            @endif
                        </p>
                        <p class="text-muted mt-0 mb-0">
                            <small>
                                {!! __('Posted by :username :date', ['username' => $thread->author->username, 'date' => $thread->created_at->diffForHumans()]) !!} — {{ __(':number replies', ['number' => $thread->replies->count()]) }}
                            </small>
                        </p>
                    </a>
                </li>
                @endforeach
            </ul>
        @endif
    </div>
    
    <div class="d-flex justify-content-center mt-3">
        {{ $threads->links() }}
    </div>
</div>