<div>
    <form wire:submit.prevent="submit">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">{{ __('Name') }}</label>
            <input wire:model.lazy="name" type="text" @class(['form-control', 'is-invalid' => $errors->first('name')]) id="name" value="{{ $this->name }}">

            @error ('name')
                <div class="invalid-feedback" role="alert">
                {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">{{ __('Description') }}</label>
            <textarea wire:model.lazy="description" @class(['form-control', 'is-invalid' => $errors->first('description')]) id="description">{{ $this->description }}</textarea>

            @error ('description')
                <div class="invalid-feedback" role="alert">
                {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="genre" class="form-label">{{ __('Genre') }}</label>
            <select wire:model.lazy="genre" @class(['form-select', 'is-invalid' => $errors->first('genre')]) id="genre">
                @foreach ($genres as $genre)
                    <option value="{{ $genre->value }}" @selected($genre == $this->genre)>{{ __($genre->fullname()) }}</option>
                @endforeach
            </select>

            @error ('genre')
                <div class="invalid-feedback" role="alert">
                {{ $message }}
                </div>
            @enderror
        </div>

        @if ($this->asset->type->isSellable())
            <div x-data="{ show: {{ $this->sell ? 'true' : 'false' }} }">
                <div class="form-check mb-3">
                    <input wire:model.lazy="sell" @class(['form-check-input', 'is-invalid' => $errors->first('sell')]) type="checkbox" id="sell" @checked($this->sell) x-model="show">
                    <label class="form-check-label" for="sell">{{ __('Sell this item') }}</label>

                    @error ('sell')
                        <div class="invalid-feedback" role="alert">
                        {{ $message }}
                        </div>
                    @enderror
                </div>

                @if (!$this->asset->type->isFree())
                    <div class="mb-3" :class="{ 'd-none': !show }">
                        <label for="price" class="form-label">{{ __('Price') }}</label>
                        <input wire:model.lazy="price" @class(['form-control', 'is-invalid' => $errors->first('price')]) id="price" value="{{ $this->price }}" @checked($this->sell)>

                        @error ('price')
                            <div class="invalid-feedback" role="alert">
                            {{ $message }}
                            </div>
                        @enderror
                    </div>
                @endif
            </div>
        @endif

        <div class="form-check mb-3">
            <input wire:model.lazy="comments" @class(['form-check-input', 'is-invalid' => $errors->first('comments')]) type="checkbox" id="comments" @checked($this->comments)>
            <label class="form-check-label" for="comments">{{ __('Allow Comments') }}</label>

            @error ('comments')
                <div class="invalid-feedback" role="alert">
                {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
        <a class="btn btn-secondary mx-2" href="{{ route('item.view', $this->asset->id) }}">{{ __('Cancel') }}</a>
    </form>
</div>
