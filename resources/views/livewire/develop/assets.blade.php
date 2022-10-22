<div>
    <div wire:loading.block class="blurred-loading-wrapper">
        <div class="blurred-loading text-center py-3" id="data-loading">
            <div role="status" class="spinner-border text-center text-secondary">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
    <div wire:loading.class="blurred">
        @if ($selected_page && $selected_page->name == 'Games')
            <button class="btn btn-primary"><h5 class="mb-0">Create New Game</h5></button>
        @endif
        @if (count($assets) > 0)
            @foreach ($assets as $asset)
                <div class="border-bottom py-3">
                    <div class="row">
                        <div class="col-2">
                            <a href="{{ route('item.view', $asset->id) }}">
                                <img src="{{ $asset->version->thumbnail() }}" alt="{{ $asset->name }}" title="{{ $asset->name }}" class="img-fluid rounded-3" width="300">
                            </a>
                        </div>
                        <div class="col-10">
                            <div class="d-flex justify-content-between mb-2">
                                <div>
                                    <p class="mb-0"><a href="{{ route('item.view', $asset->id) }}">{{ $asset->name }}</a></p>
                                    <p class="mb-0"><small class="text-muted">Created: {{ date('n/j/Y \a\t g:i A', strtotime($asset->created_at)) }}</small></p>
                                    <p class="mb-0"><small class="text-muted">Last updated: {{ date('n/j/Y \a\t g:i A', strtotime($asset->updated_at)) }}</small></p>
                                </div>
                                <div>
                                    <div class="dropdown">
                                        <button class="btn btn-primary px-1 py-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="fa-stack">
                                                <i class="fa-solid fa-cog"></i>
                                                <i class="fa-solid fa-angle-down"></i>
                                            </span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="{{ route('item.configure', $asset->id) }}">Configure</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="d-flex flex-column align-items-center pt-5">
                <img src="{{ asset('img/noobs/painter.png') }}" class="img-fluid" width="200">
                <h3 class="my-2">{{ __('You haven\'t created any :asset_type_plural yet', ["asset_type_plural" => $selected_type ? Str::plural(__($selected_type->fullname())) : __($selected_page->name)]) }}</h2>
                <p class="text-muted">{{ __('Creating one is quick and easy!') }}</p>
            </div>
        @endif
    </div>
</div>
