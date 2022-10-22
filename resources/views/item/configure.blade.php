<x-app-layout :title="__('Configure :asset_type ', ['asset_type' => __($asset->type->fullname())])">
    <div class="container">
        <h2>{{ __('Configure :asset_type ', ['asset_type' => __($asset->type->fullname())]) }}</h2>
        <div style="max-width:73rem">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="card mb-3">
                                <div class="card-body text-center">
                                    <img src="{{ $asset->version->thumbnail() }}" alt="{{ $asset->name }}" title="{{ $asset->name }}" class="img-fluid rounded-3">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <livewire:item.configure :asset="$asset" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
