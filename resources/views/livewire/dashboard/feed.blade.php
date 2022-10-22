<div wire:init="load">
    <div class="input-group mb-3">
        <input wire:model.defer="status" @class(['form-control', 'is-invalid' => $errors->first('status')]) aria-label="{{ __('Current status') }}" placeholder="{{ __('What are you up to?') }}" aria-describedby="share-button" type="text">
        <button wire:click="share" type="button" id="share-button" class="btn btn-primary">{{ __('Share') }}</button>

        @error ('status')
            <div class="invalid-feedback" role="alert">
                {{ $message }}
            </div>
        @enderror
    </div>

    <h2>{{ __('My Feed') }}</h2>

    <div class="border-top mt-2"></div>

    @if ($loading)
        <div class="d-flex flex-column align-items-center py-5">
            <img src="{{ asset('img/noobs/status/speaking.gif') }}" width="75">
            <span class="text-muted mt-2">{{ __('Fetching your feed...') }}</span>
        </div>
    @else
        <div wire:key="dashboard.feed-{{ now() }}" wire:poll.300000ms wire:loading.class="blurred" class="h-100">
            @forelse ($posts as $post)
                <div class="border-bottom py-3">
                    <div class="row px-2">
                        <div class="col-auto d-flex align-items-center">
                            <a href="{{ route('users.profile', $post->creator->id) }}">
                                <x-user.headshot :user="$post->creator" width="70" />
                            </a>
                        </div>

                        <div class="col ps-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('users.profile', $post->creator->id) }}">{{ $post->creator->username }}</a>
                                <i class="fa-regular fa-flag-swallowtail text-danger"></i>
                            </div>

                            <p class="mb-0 text-truncate">&ldquo;{{ $post->content }}&rdquo;</p>

                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">{{ date('n/j/Y \a\t g:i A', strtotime($post->created_at)) }}</small>

                                <div>
                                    <button class="btn btn-sm btn-light me-2"><i class="fa-regular fa-messages"></i></button>
                                    <button class="btn btn-sm btn-light"><i class="fa-regular fa-face-smile-plus me-1"></i>{{ __('Yeah!') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="d-flex flex-column align-items-center py-5">
                    <img src="{{ asset('img/noobs/sad.png') }}" width="150">
                    <h4 class="mt-3 mb-1">{{ __('Your feed is empty') }}</h2>
                    <p class="text-muted">{{ __('You might want to make some friends...') }}</p>
                </div>
            @endforelse
        </div>
    @endif
</div>
