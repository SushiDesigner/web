<x-app-layout :title="$category->name">
    <div class="container">
        <div class="px-3">
            <div class="row">
                @include('forum.sidebar')
                <div class="col">
                    <div class="col-body">
                        <div style="background-color: {{ $category->color }};" class="w-100 p-3 rounded mb-3 align-content-center">
                            <h3 class="text-stroke font-weight-bold text-light mt-0 mb-0">{{ $category->name }}</h3>
                            <p class="text-stroke mb-0 mt-0 text-light">{{ $category->description }}</p>
                        </div>

                        <livewire:forum.threads :category="$category" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
