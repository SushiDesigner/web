<x-app-layout :title="__('Create Site Alert')">
    <div class="container">
        <div class="rounded-2 bg-lightish px-3 py-2 mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">{{ __('Admin') }}</a></li>
                    <li class="breadcrumb-item">{{ __('Superadmin Tools') }}</li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Create Site Alert') }}</li>
                </ol>
            </nav>
        </div>

        <h1>{{ __('Create Site Alert') }}</h1>
        <p>{{ __('Creates a site alert viewable to all visitors on the :project website. Note that this is not permanent and goes away once the cache is reset.', ['project' => config('app.name')]) }}</p>

        <div class="border-bottom my-3"></div>

        <livewire:admin.alert />
    </div>
</x-app-layout>
