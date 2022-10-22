<div class="col mb-3">
    <div @class(['card hover', 'border-' . $color])>
        <div class="card-body">
            <div @class(['d-flex flex-column align-items-center', 'text-' . $color])>
                @isset ($icon)
                    <i @class(['fa-solid fa-2x fa-fw mb-2', $icon])></i>
                @else
                    <img src="{{ $photo }}" height="32" class="mb-2">
                @endisset

                <a href="{{ $link }}" @class(['stretched-link text-decoration-none', 'text-' . $color])>{{ $action }}</a>
            </div>
        </div>
    </div>
</div>
