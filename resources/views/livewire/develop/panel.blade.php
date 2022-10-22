<div>
    <div class="row row-cols-md-2 row-cols-1">
        <div class="col col-xl-2 col-lg-3 col-md-3 mb-md-0 mb-3 border-md-end border-sm-end-0">
            <div class="nav flex-column nav-pills" id="pills-tab" role="tab-list" aria-orientation="vertical">
                @foreach ($pages as $page)
                    <a wire:click="setPage('{{ $page->value }}')" @class(['nav-link small-pill mb-1', 'active' => ($page == $selected_page)]) href="#{{ Str::lower($page->name) }}">
                        <i @class(['fa-fw me-2 fa-regular', $page->fontAwesomeIcon()])></i>{{ __($page->name) }}
                    </a>
                @endforeach

                @foreach ($types as $type)
                    <a wire:click="setType({{ $type->value }})" @class(['nav-link small-pill mb-1', 'active' => ($type == $selected_type)]) href="#{{ Str::lower(Str::plural($type->name)) }}">
                        <i @class(['fa-fw me-2 fa-regular', $type->fontAwesomeIcon()])></i>{{ Str::plural(__($type->fullname())) }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="col col-xl-10 col-lg-9 col-md-9">
            <div class="pt-2 pt-md-0 border-md-top-0 border-sm-top border-xs-top">
                <div wire:loading.block class="blurred-loading-wrapper">
                    <div class="blurred-loading text-center py-3" id="data-loading">
                        <div role="status" class="spinner-border text-center text-secondary">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div wire:loading.class="blurred">
                    @if ($selected_type && $selected_type->isDevelopCreatable())
                        <livewire:develop.create wire:key="develop.create-{{ now() }}" :selected_type="$selected_type">
                        <div class="mt-3 border-bottom"></div>
                    @endif
                    <livewire:develop.assets wire:key="develop.assets-{{ now() }}" :selected_type="$selected_type" :selected_page="$selected_page">
                </div>
            </div>
        </div>
    </div>
</div>
