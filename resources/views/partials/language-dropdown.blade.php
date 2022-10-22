<div class="dropdown">
    <a href="#" class="text-muted text-decoration-none hover-action py-1 px-2" data-tadah-magic="language-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fa-regular fa-earth-americas me-1"></i>{{ str_replace('_', '-', app()->getLocale()) }}<i class="fa-regular fa-caret-down ms-1"></i>
    </a>
    <ul class="dropdown-menu" aria-labelledby="language-dropdown">
        @foreach (config('app.available_locales') as $language => $locale)
            <li><a class="dropdown-item" href="{{ route('language', $locale) }}"><span class="me-1">{!! countryCodeToEmoji(config('app.country_flags')[$locale]) !!}</span>{{ $language }} ({{ str_replace('_', '-', $locale) }})</a></li>
        @endforeach
    </ul>
</div>
