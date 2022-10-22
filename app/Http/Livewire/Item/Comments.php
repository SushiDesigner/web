<?php

namespace App\Http\Livewire\Item;

use Livewire\Component;

class Comments extends Component
{
    /**
     * @var Asset
     */
    public $asset;

    public function mount()
    {
        abort_unless($this->asset->comments_enabled, 404);
    }

    public function render()
    {
        return view('livewire.item.comments');
    }
}
