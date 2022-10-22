<footer class="footer mt-auto">
    <div class="bg-dark mt-3 shadow-sm">
        <div class="container pt-3 pb-4">
            <ul class="nb-ul list-group list-group-horizontal nav">
                <li class="flex-fill text-center"><a href="{{ route('document', 'tos')}}" class="text-light opacity-50 fw-light h5 nav-item px-3 py-3 small-text-sm text-decoration-none footer-link">{{ __('Terms of Service') }}</a></li>
                <li class="flex-fill text-center"><a href="{{ route('document', 'rules') }}" class="text-light opacity-50 fw-light h5 nav-item px-3 py-3 small-text-sm text-decoration-none footer-link">{{ __('Rules') }}</a></li>
                <li class="flex-fill text-center"><a href="{{ route('document', 'privacy') }}" class="text-light opacity-50 fw-light h5 nav-item px-3 py-3 small-text-sm text-decoration-none footer-link">{{ __('Privacy Policy') }}</a></li>
                <li class="flex-fill text-center"><a href="{{ route('document', 'statistics') }}" class="text-light opacity-50 fw-light h5 nav-item px-3 py-3 small-text-sm text-decoration-none footer-link">{{ __('Statistics') }}</a></li>
            </ul>

            <hr class="text-light opacity-25">

            <div class="row row-cols-md-2 row-cols-1">
                <div class="col col-md-3">
                    <div class="dropup w-100">
                        <button type="button" id="footer-dropdown" data-bs-toggle="dropdown" class="btn btn-outline-light opacity-25 dropdown-toggle btn-lg btn-block w-100 text-start d-flex justify-content-between align-items-center" aria-expanded="false">
                            <span><i class="fa-solid fa-globe-americas me-1"></i>{{ array_search(app()->getLocale(), config('app.available_locales')) }}</span>
                        </button>

                        <ul class="dropdown-menu w-100 fs-5" aria-labelledby="footer-dropdown">
                            @foreach (config('app.available_locales') as $language => $locale)
                                <li><a class="dropdown-item" href="{{ route('language', $locale) }}"><span class="me-1">{!! countryCodeToEmoji(config('app.country_flags')[$locale]) !!}</span>{{ $language }} ({{ str_replace('_', '-', $locale) }})</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="col col-md-6 text-start text-light opacity-25 mt-md-0 mt-3 px-3">
                    {{ __('© :year :project. :project is a is a not-for-profit private community. :project is not associated with, does not deal with, or a subsidy of any corporation.', ['year' => \Carbon\Carbon::now()->year, 'project' => config('app.name')]) }}
                </div>

                <div class="col col-md-3 d-flex align-items-center justify-content-center mt-md-0 mt-3">
                    <div class="row row-cols-5">
                        <div class="col"><a href="https://discord.gg/tadah" class="text-decoration-none opacity-25 footer-link text-light"><i class="fa-brands fa-discord fs-3"></i></a></div>
                        <div class="col"><a href="https://twitter.com/TadahCommunity" class="text-decoration-none opacity-25 footer-link text-light"><i class="fa-brands fa-twitter fs-3"></i></a></div>
                        <div class="col"><a href="https://www.youtube.com/channel/UCI6HZETsKzq_PWzhBrmY49Q" class="text-decoration-none opacity-25 footer-link text-light"><i class="fa-brands fa-youtube fs-3"></i></a></div>
                        <div class="col"><a href="https://github.com/tadah-foss" class="text-decoration-none opacity-25 footer-link text-light"><i class="fa-brands fa-github fs-3"></i></a></div>
                        <div class="col"><a href="{{ 'mailto:' . getInboxAddress() }}" class="text-decoration-none opacity-25 footer-link text-light"><i class="fa-solid fa-envelope fs-3"></i></a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
