<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <script type="text/javascript">
            window.tadah = @json($context)
        </script>

        <title>{{ $title }}</title>
        <link rel="stylesheet" href="{{ asset(mix('css/app.css')) }}">
        <livewire:styles />

        @isset ($head)
            {{ $head }}
        @endif
    </head>

    <body class="d-flex flex-column h-100">
        @if ($fluff)
            @include ('partials.navigation')
        @endif

        @if ($fluff)
            <main class="flex-shrink-0 py-3">
                <div class="container">
                    <div class="alert alert-success mb-4 shadow-sm d-none fade show alert-dismissible" role="alert" id="container-success">
                        <span></span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
                    </div>

                    <div class="alert alert-danger mb-4 shadow-sm d-none fade show alert-dismissible" role="alert" id="container-error">
                        <span></span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
                    </div>
                </div>

                {{ $slot }}
            </main>
        @else
            {{ $slot }}
        @endif

        @if ($fluff)
            @include ('partials.footer')
        @endif

        <script src="{{ asset(mix('js/app.js')) }}"></script>
        <livewire:scripts />

        @isset ($scripts)
            {{ $scripts }}
        @endisset
    </body>
</html>
