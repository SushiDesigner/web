<div>
    <h3>{{ __('Create :asset_type', ['asset_type' => __($selected_type->fullname())]) }}</h3>
    <form wire:submit.prevent="upload">
        @csrf

        <div class="mb-3 row">
            <label for="asset-file" class="col-xl-2 col-lg-3 col-md-4 col-form-label">Find your image:</label>
            <div class="col-xl-10 col-lg-9 col-md-8" x-data="{ progress: 0 }" x-on:livewire-upload-progress="progress = $event.detail.progress">
                <input wire:model.lazy="asset_file" type="file" @class(['form-control', 'is-invalid' => $errors->first('asset_file')]) id="asset-file">
                <div wire:loading wire:target="asset_file" class="mt-1 text-secondary">
                    <span role="status" class="spinner-border spinner-border-sm"></span>
                    Uploading, please wait... (<span x-text="progress"></span>%)
                </div>
                @error ('asset_file')
                    <div class="invalid-feedback" role="alert">
                    {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="mb-3 row">
            <label for="asset-name" class="col-xl-2 col-lg-3 col-md-4 col-form-label">{{ __(':asset_type Name:', ['asset_type' => __($selected_type->fullname())]) }} </label>
            <div class="col-xl-10 col-lg-9 col-md-8">
                <input wire:model.lazy="asset_name" type="text" @class(['form-control', 'is-invalid' => $errors->first('asset_name')]) id="asset-name">
                @error ('asset_name')
                    <div class="invalid-feedback" role="alert">
                    {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        @error ('asset_error')
            <div class="text-danger" role="alert">
            {{ $message }}
            </div>
        @enderror

        <button wire:loading.attr="disabled" wire:target="asset_file" type="submit" class="btn btn-primary">{{ __('Create') }}</button>
    </form>
</div>
