<x-app-layout :title="$title" fluff="off">
    <main class="flex-shrink-0 d-flex align-items-center min-vh-100">
        <div class="container">
            <div class="my-3 d-flex flex-column align-items-center">
                <div class="card border-0 shadow rounded-4 p-4">
                    <div class="card-body text-center">
                        <img src="{{ asset('img/blobs/' . $blob . '.png') }}" class="img-fluid">
                        <div class="border-bottom my-3"></div>
                        <h3>{{ $code }}</h3>
                        <span>{{ $message }}</span>
                        <div class="d-flex justify-content-center mt-3">
                            <button class="btn btn-secondary me-2 shadow-sm" role="button" onclick="window.history.back()">{{ __('Go back') }}</button>
                            <a class="btn btn-primary" href="{{ url('/') }}" role="button">{{ __('Home') }}</a>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    @include ('partials.language-dropdown')
                </div>
            </div>
        </div>
    </main>
</x-app-layout>
