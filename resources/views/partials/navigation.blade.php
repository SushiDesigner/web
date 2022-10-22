<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img alt="{{ config('app.name') }}" src="{{ asset('img/logo/small.png') }}" height="30" width="30" class="d-inline-block align-top me-2">
                {{ config('app.name') }}
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a @class(['nav-link', 'active' => active_link('dashboard', 2)]) href="{{ url('/') }}">{{ __('Home') }}</a>
                    </li>

                    <li class="nav-item">
                        <a @class(['nav-link', 'active' => active_link('games')]) href="{{ route('games') }}">{{ __('Games') }}</a>
                    </li>

                    <li class="nav-item">
                        <a @class(['nav-link', 'active' => active_link('catalog')]) href="{{ route('catalog') }}">{{ __('Catalog') }}</a>
                    </li>

                    <li class="nav-item">
                        <a @class(['nav-link', 'active' => active_link('users')]) href="{{ route('users') }}">{{ __('People') }}</a>
                    </li>

                    <li class="nav-item">
                        <a @class(['nav-link', 'active' => active_link('develop')]) href="{{ route('develop') }}">{{ __('Develop') }}</a>
                    </li>

                    <li class="nav-item">
                        <a @class(['nav-link', 'active' => active_link('forum')]) href="{{ route('forum') }}">{{ __('Forum') }}</a>
                    </li>
                </ul>

                <div class="align-self-center col-lg-4 col-xl-4 col-sm-8 col-md-4">
                    <livewire:layout.search-bar />
                </div>

                <ul class="navbar-nav ms-auto align-items-center">
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item me-auto">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item me-auto">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        @may (Admin::roleset(), Admin::VIEW_PANEL)
                            <li class="nav-item me-auto">
                                <a @class(['nav-link', 'active' => active_link('admin')]) href="{{ route('admin') }}"><i class="fa-solid fa-hammer fa-sm d-lg-block d-none"></i><span class="d-lg-none">{{ __('Admin') }}</span></a>
                            </li>
                            <div class="navbar-divider d-none d-lg-block"></div>
                        @endmay

                        <li class="nav-item me-auto">
                            <a class="nav-link d-flex align-items-center" href="{{ route('users.profile', auth()->user()->id) }}">
                                <x-user.headshot :user="auth()->user()" width="19" class="me-2" />
                                {{ Auth::user()->username }}
                            </a>
                        </li>

                        <div class="navbar-divider d-none d-lg-block"></div>

                        <li class="nav-item me-auto yass">
                            <a class="nav-link d-flex align-items-center" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Currency has not been implemented yet!">
                                <div class="dahllor-icon dahllor-icon-navbar me-1"></div>
                                ---
                            </a>
                        </li>

                        <div class="navbar-divider d-none d-lg-block me-3"></div>

                        <li class="nav-item me-auto">
                            <form method="post" action="{{ route('logout') }}">
                                @csrf
                                <a href="#" class="nav-link btn btn-sm btn-outline-primary btn-logout py-1 px-2 tadah-link-submit" type="submit">{{ __('Logout') }}</a>
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    @if (Auth::check())
        <div class="navbar navbar-scroller navbar-expand-md navbar-dark bg-dark py-0 shadow-sm">
            <div class="container">
                <button class="navbar-toggler border-0 py-2" type="button" data-bs-toggle="collapse" data-bs-target="#secondaryNavbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="{{ __('Toggle secondary navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="secondaryNavbarCollapse">
                    <ul class="navbar-nav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a @class(['nav-link', 'active' => active_link('account')]) href="{{ route('account') }}">{{ __('Account') }}</a>
                            </li>

                            <li class="nav-item">
                                <a @class(['nav-link', 'active' => active_link('invites')]) href="{{ route('invites') }}">{{ __('Invites') }}</a>
                            </li>
                        </ul>
                    </ul>
                </div>
            </div>
        </div>

        @if (!is_null($alert = Cache::get('alert')))
            <div class="alert border-0 shadow-sm rounded-0 p-1 text-center" style="background-color: {{ $alert->color }}">
                @parsedown ($alert->text)
            </div>
        @endisset
    @endif
</header>
