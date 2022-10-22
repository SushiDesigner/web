<x-app-layout :title="__('Dashboard')">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 border-lg-end border-md-end-0 border-lg-bottom-0 border-md-bottom border-sm-bottom border-xs-bottom ps-md-3 pe-md-0 mb-3">
                <div class="text-center border-bottom px-0 px-md-3 pb-3">
                    <div class="mb-2 text-center py-1"><h3 class="m-0 text-truncate">{!! __(':greeting, <b>:username</b>!', compact('greeting', 'username')) !!}</h3></div>
                    <x-user.thumbnail :user="auth()->user()" class="img-fluid" width="300px" />
                </div>

                <div class="border-bottom px-0 pe-lg-3 py-3">
                    <h4>{{ __(':project News', ['project' => config('app.name')]) }}</h4>

                    <x-account::dashboard.news />
                </div>

                <div class="px-0 pe-lg-3 py-3">
                    <livewire:dashboard.best-friends />
                </div>
            </div>

            <div class="col-lg-6 border-lg-end border-md-end-0 border-lg-bottom-0 border-md-bottom border-sm-bottom border-xs-bottom mb-3 px-3">
                <livewire:dashboard.feed />
            </div>

            <div class="col-lg-3 px-3 pb-3">
                <h4>{{ __('Recently Played Games') }}</h4>
                <livewire:dashboard.recently-played-games />
            </div>
        </div>
    </div>
</x-app-layout>
