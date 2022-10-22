<x-app-layout fluff="off">
    <x-slot:head>
        <meta property="og:title" content="{{ __(':project - Welcome', ['project' => config('app.name')]) }}">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url('/') }}">
        <meta property="og:image" content="{{ asset('img/logo/small.png') }}">
        <meta property="og:description" content="{{ __(':project is a tight-knit community of like-minded people.', ['project' => config('app.name')]) }}">
        <meta name="theme-color" content="#455DD8">
    </x-slot>

    <main class="landing-page vh-100 justify-content-center align-items-center d-flex">
        <video preload muted autoplay loop>
            <source src="{{ asset('vid/landing.webm') }}" type="video/webm">
            <source src="{{ asset('vid/landing.mp4') }}" type="video/mp4">

            {{ __('Sorry, your browser doesn\'t support embedded videos.') }}
        </video>

        <div class="container text-center">
            <img src="{{ asset('img/logo/big.png') }}" class="img-fluid" width="500">
            <p class="lead my-3 motto user-select-none">
                {{ __('A diverse community of creative people.') }}
            </p>
            <a href="{{ route('login') }}" class="btn btn-secondary btn-lg shadow me-3 text-light"><i class="fa-solid fa-sign-in-alt me-1"></i>{{ __('Login') }}</a>
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg shadow text-light"><i class="fa-solid fa-user-plus me-1"></i>{{ __('Sign Up') }}</a>
        </div>
    </main>
</x-app-layout>
