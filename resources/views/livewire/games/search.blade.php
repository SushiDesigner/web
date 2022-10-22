<div>
    <div class="row row-cols-md-2 row-cols-1">
        <div class="col col-xl-2 col-md-3">
            <span class="text-muted">{{ __('Sorted by:') }}</span>

            <select class="form-select my-2 d-md-none" aria-label="{{ __('Set sort') }}">
                @foreach ($sorts as $sort)
                    @if ($sort == $selected_sort)
                        <option selected>{{ __($sort->fullname()) }}</option>
                    @else
                        <option wire:click="setSort({{ $sort->value }})">{{ __($sort->fullname()) }}</option>
                    @endif
                @endforeach
            </select>

            <ul class="mb-2 list-unstyled d-md-block d-none">
                @foreach ($sorts as $sort)
                    @if ($sort == $selected_sort)
                        <li><i class="fa-solid fa-caret-right me-2 text-danger"></i><a href="#" class="text-decoration-none">{{ __($sort->fullname()) }}</a></li>
                    @else
                        <li><a wire:click="setSort({{ $sort->value }})" href="#" class="text-decoration-none ps-3">{{ __($sort->fullname()) }}</a></li>
                    @endif
                @endforeach
            </ul>

            <span class="text-muted">{{ __('Genres:') }}</span>

            <select class="form-select my-2 d-md-none" aria-label="{{ __('Set genre') }}">
                @foreach ($genres as $genre)
                    @if ($genre == $selected_genre)
                        <option selected>{{ __($genre->fullname()) }}</option>
                    @else
                        <option wire:click="setGenre({{ $genre->value }})">{{ __($genre->fullname()) }}</option>
                    @endif
                @endforeach
            </select>

            <ul class="mb-2 list-unstyled d-md-block d-none">
                @foreach ($genres as $genre)
                    @if ($genre == $selected_genre)
                        <li><i class="fa-solid fa-caret-right me-2 text-danger"></i><a href="#" class="text-decoration-none">{{ __($genre->fullname()) }}</a></li>
                    @else
                        <li><a wire:click="setGenre({{ $genre->value }})" href="#" class="text-decoration-none ps-3">{{ __($genre->fullname()) }}</a></li>
                    @endif
                @endforeach
            </ul>
        </div>

        <div class="col col-xl-10 col-md-9 col-sm mt-md-0 mt-3">
            <ul class="nav nav-tabs floating-nav-tabs" role="tab-list">
                <li class="nav-item">
                    <a class="nav-link floating-tab active" data-bs-toggle="tab" role="tab" aria-selected="true" aria-current="page" href="#games">{{ __('Games') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link floating-tab" data-bs-toggle="tab" role="tab" aria-current="page" href="#pbs">{{ __('Personal Servers') }}</a>
                </li>
                <li class="nav-item ms-auto align-items-center d-flex">
                    <div class="input-group">
                        <input type="text" placeholder="{{ __('Search') }}" aria-label="Game name" aria-describedby="search-button" class="form-control form-control-sm search-games-form">
                        <button type="button" class="btn btn-primary btn-sm"><i class="fa-solid fa-search"></i></button>
                    </div>
                </li>
            </ul>

            <div class="tab-content min-vh-100">
                <div class="tab-pane floating-tab-page start show active vh-100" role="tabpanel" aria-labelledby="games" id="games">
                    Games
                </div>
                <div class="tab-pane floating-tab-page vh-100" role="tabpanel" aria-labelledby="pbs" id="pbs">
                    PBS
                </div>
            </div>
        </div>
    </div>
</div>
