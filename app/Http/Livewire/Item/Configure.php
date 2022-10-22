<?php

namespace App\Http\Livewire\Item;

use App\Enums\AssetType;
use App\Enums\AssetGenre;
use App\Models\Asset;
use Illuminate\Validation\Validator;
use Illuminate\Validation\Rules\Enum;
use Livewire\Component;

class Configure extends Component
{
    /**
     * @var Asset
     */
    public $asset;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $description;

    /**
     * @var int|AssetGenre
     */
    public $genre;

    /**
     * @var bool
     */
    public $sell;

    /**
     * @var int
     */
    public $price;

    /**
     * @var bool
     */
    public $comments;

    /**
     * @return array
     */
    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:50'],
            'description' => ['required', 'string', 'max:1000'],
            'genre' => [new Enum(AssetGenre::class)],
            // 'price' => ['integer', 'min:0', 'max:1000'],
        ];
    }

    public function mount()
    {
        abort_unless($this->asset->canConfigure(), 404);

        $this->name = $this->asset->name;
        $this->description = $this->asset->description;
        $this->genre = $this->asset->genre->value;
        $this->sell = $this->asset->is_for_sale;
        $this->price = $this->asset->price;
        $this->comments = $this->asset->comments_enabled;
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function submit()
    {
        $this->withValidator(function (Validator $validator) {
            $validator->sometimes('price', ['required', 'integer', 'min:0', 'max:1000'], function ($input){
                return !is_null($this->sell);
            });
        })->validate();

        $this->asset->name = $this->name;
        $this->asset->description = $this->description;
        $this->asset->genre = $this->genre;
        $this->asset->comments_enabled = $this->comments ?? false;

        if ($this->asset->type->isSellable())
        {
            $this->asset->is_for_sale = $this->sell ?? false;

            if ($this->asset->type == AssetType::Model)
            {
                $this->asset->is_public_domain = $this->asset->is_for_sale;
            }

            if ($this->sell && !$this->asset->type->isFree())
            {
                $this->asset->price = $this->price;
            }
        }

        $this->asset->save();

        $this->dispatchBrowserEvent('success', __('Successfully updated :asset_type.', ["asset_type" => __($this->asset->type->fullname())]));
    }

    public function render()
    {
        $genres = AssetGenre::cases();

        return view('livewire.item.configure', compact('genres'));
    }
}
