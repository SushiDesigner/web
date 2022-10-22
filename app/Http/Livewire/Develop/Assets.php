<?php

namespace App\Http\Livewire\Develop;

use App\Enums\AssetType;
use App\Enums\DevelopPage;
use App\Enums\CreatorType;
use App\Models\Asset;
use App\Models\Universe;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Assets extends Component
{
    use WithPagination;

    /**
     * @var AssetType
     */
    public $selected_type;

    /**
     * @var DevelopPage
     */
    public $selected_page;

    protected $listeners = ['assetCreated' => 'render'];

    public function __construct()
    {
        abort_unless(Auth::check(), 401);
    }

    public function render()
    {
        if ($this->selected_type)
        {
            abort_unless($this->selected_type->isDevelopType(), 401);
            
            $assets = Asset::where('creator_id', Auth::user()->id)
                ->where('creator_type', CreatorType::User->value)
                ->where('type', $this->selected_type->value)
                ->orderBy('created_at', 'desc')
                ->get();
        }
        else
        {      
            abort_unless($this->selected_page, 401);

            if ($this->selected_page == DevelopPage::Games)
            {
                $assets = Universe::where('creator_id', Auth::user()->id)
                    ->where('creator_type', CreatorType::User->value)
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
        }

        return view('livewire.develop.assets', [
            'assets' => paginate($assets, 10),
            'selected_type' => $this->selected_type,
            'selected_page' => $this->selected_page
        ]);
    }
}
