<x-app-layout :title="__(':asset_name, a :asset_type by :creator_name', ['asset_name' => $asset->name, 'asset_type' => __($asset->type->fullname()), 'creator_name' => $asset->creator->username])">
    <div class="container">
        <div style="max-width:73rem">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="card">
                                <div class="card-body text-center">
                                    <img src="{{ $asset->version->thumbnail() }}" alt="{{ $asset->name }}" title="{{ $asset->name }}" class="img-fluid rounded-3">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="border-bottom mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <div>
                                        <h2 class="mb-0">{{ $asset->name }}</h2>
                                        <p>By <a href="{{ route('users.profile', $asset->creator->id) }}">{{ $asset->creator->username }}</a></p>
                                    </div>
                                    @if ($asset->ownership() || $asset->canConfigure())
                                        <div>
                                            <div class="dropdown">
                                                <button class="btn btn-primary px-1 py-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <span class="fa-stack">
                                                        <i class="fa-solid fa-cog"></i>
                                                        <i class="fa-solid fa-angle-down"></i>
                                                    </span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    @if ($asset->ownership())
                                                        @if ($asset->type->isWearable())
                                                            <li><a class="dropdown-item" href="#">{{ $asset->ownership()->wearing ? __('Take Off Item') : __('Wear Item') }}</a></li>
                                                        @endif
                                                        <li><a class="dropdown-item" href="#">{{ __('Delete from My Stuff') }}</a></li>
                                                    @endif
                                                    @if ($asset->canConfigure())
                                                        <li><a class="dropdown-item" href="{{ route('item.configure', $asset->id) }}">{{ __('Configure this :asset_type', ['asset_type' => $asset->type->fullname()]) }}</a></li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row gy-2">
                                @if (!$asset->is_for_sale)
                                    <div class="col-12">
                                        @if ($asset->ownership())
                                            <p>{{ __('You already own this item.') }}</p>
                                        @else
                                            <p>{{ __('This item is not currently for sale.') }}</p>
                                        @endif
                                    </div>
                                @else
                                    @if ($asset->ownership())
                                        <div class="col-12">
                                            <p>{{ __('You already own this item.') }}</p>
                                        </div>
                                    @endif
                                    <div class="col-lg-3 col-md-4 col-5 text-muted">{{ _('Price') }}</div>
                                    <div class="col-lg-9 col-md-8 col-7">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            @if ($asset->price > 0)
                                                <h3 class="text-success mb-0"><span class="dahllor-icon me-1"></span> {{ number_format($asset->price) }}</h3>
                                            @else
                                                <h3 class="text-success mb-0">{{ __('Free') }}</h3>
                                            @endif

                                            @if (!$asset->ownership())
                                                <button class="btn btn-lg btn-success px-5 text-light" type="button">Buy</button>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <div class="col-lg-3 col-md-4 col-5 text-muted">{{ __('Type') }}</div>
                                <div class="col-lg-9 col-md-8 col-7">{{ __($asset->type->fullname()) }}</div>

                                <div class="col-lg-3 col-md-4 col-5 text-muted">{{ __('Genre') }}</div>
                                <div class="col-lg-9 col-md-8 col-7">{{ __($asset->genre->fullname()) }}</div>

                                <div class="col-lg-3 col-md-4 col-5 text-muted">{{ __('Created') }}</div>
                                <div class="col-lg-9 col-md-8 col-7">{{ date('M d, Y g:i:s A', strtotime($asset->created_at)) }}</div>

                                <div class="col-lg-3 col-md-4 col-5 text-muted">{{ __('Updated') }}</div>
                                <div class="col-lg-9 col-md-8 col-7">{{ date('M d, Y g:i:s A', strtotime($asset->updated_at)) }}</div>

                                <div class="col-lg-3 col-md-4 col-5 text-muted">{{ __('Description') }}</div>
                                <div class="col-lg-9 col-md-8 col-7">"{{ $asset->description }}"</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <livewire:item.comments :asset="$asset" />
        </div>
    </div>
</x-app-layout>
