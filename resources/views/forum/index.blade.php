<x-app-layout :title="__('Forum')">
    <div class="container">
        <div class="px-3">
            <div class="row">
                @include('forum.sidebar')
                <div class="col">
                    <div class="col-body">
                        <div class="w-100 bg-primary p-3 rounded mb-3 align-content-center">
                            <h3 class="font-weight-bold text-light mt-0 mb-0">{{ __(':project Forum', ['project' => config('app.name')]) }}</h3>
                        </div>

                        <livewire:forum.threads />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
