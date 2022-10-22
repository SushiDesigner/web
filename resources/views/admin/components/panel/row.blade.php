@if ($slot->isNotEmpty())
    <h3>{{ $title }}</h3>
    <div class="border-bottom my-3"></div>
    <div class="row row-cols-md-4 row-cols-sm-3 row-cols-2 mb-3">
        {{ $slot }}
    </div>
@endif
