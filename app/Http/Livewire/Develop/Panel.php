<?php

namespace App\Http\Livewire\Develop;

use App\Enums\AssetType;
use App\Enums\DevelopPage;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Panel extends Component
{
    /**
     * @var AssetType
     */
    public $selected_type = AssetType::Place;

    /**
     * @var DevelopPage
     */
    public $selected_page = false;

    public function __construct()
    {
        abort_unless(Auth::check(), 401);
    }

    public function setType($enum_value)
    {
        $type = AssetType::tryFrom($enum_value);
        
        if (is_null($type) || !$type->isDevelopType())
        {
            $this->reset('selected_type');
            $this->reset('selected_page');
        }

        $this->selected_type = $type;
        $this->selected_page = false;
    }

    public function setPage($enum_value)
    {
        $page = DevelopPage::tryFrom($enum_value);
        
        if (is_null($page))
        {
            $this->reset('selected_type');
            $this->reset('selected_page');
        }

        $this->selected_type = false;
        $this->selected_page = $page;
    }

    public function render()
    {
        return view('livewire.develop.panel', [
            'types' => AssetType::developTypes(),
            'pages' => DevelopPage::developPages(),
            'selected_type' => $this->selected_type,
            'selected_page' => $this->selected_page
        ]);
    }
}
