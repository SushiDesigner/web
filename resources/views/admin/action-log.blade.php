<x-app-layout :title="__('Action Log')">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin') }}">{{ __('Admin') }}</a></li>
                <li class="breadcrumb-item">{{ __('Superadmin Tools') }}</li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('View Action Log') }}</li>
            </ol>
        </nav>

        <h1>{{ __('Action Log') }}</h1>
        <p>{{ __('A log for each moderation action. You can search by username to see the actions performed by a user.') }}</p>

        <div class="border-bottom my-3"></div>

        <div class="tab-pane floating-tab-page" role="tabpanel" aria-labelledby="list" id="list">
            <livewire:admin.action-log />
        </div>
    </div>
</x-app-layout>
