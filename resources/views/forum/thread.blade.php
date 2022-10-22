<x-app-layout :title="$thread->title">
    <div class="container">
        <div class="px-3">
            <div class="col">
                <div class="col-body">
                    <livewire:forum.thread :thread="$thread" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
