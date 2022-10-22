<div class="col col-md-2 col-sm-2 mb-3 my-md-0">
    <div class="d-flex align-items-center w-100 my-2">
        @if (Auth::check())
            @may (Users::roleset(), Forums::CREATE_THREADS)
            <div class="mb-0 w-100">
                <a class="w-100 btn btn-success text-light" href="#"><i class="fa-solid fa-pen-line"></i></a>
            </div>
            @endmay
        @endif
    </div>
    <hr class="mb-1">
    <div class="list-group">
        <div class="input-group input-group-sm mt-2 mb-2">
            <input type="text" class="form-control" aria-label="{{ __('Search Forum') }}" aria-describedby="inputGroup-sizing-sm" placeholder="{{ __('Search Forum') }}">
            <button class="btn btn-outline-primary" type="button" id="button-addon2"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
        <span class="text-muted">{{ __('Forum Categories') }}</span>
        @foreach ($categories as $category)
            <a href="{{ route('forum.category', $category->id) }}" class="text-decoration-none">                        
                <i style="color: {{ $category->color }};" class="fa-solid fa-circle-small"></i> {{$category->name}}
            </a>
        @endforeach
    </div>
    <hr class="d-md-none">
</div>