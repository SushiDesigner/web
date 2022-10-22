<?php

namespace App\Http\Livewire\Games;

use App\Enums\AssetGenre;
use App\Enums\PlaceSort;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Search extends Component
{
    /**
     * @var AssetGenre
     */
    public $genre = AssetGenre::All;

    /**
     * @var PlaceSort
     */
    public $sort = PlaceSort::MostPopular;

    public function __construct()
    {
        abort_unless(Auth::check(), 401);
    }

    public function setSort($enum_value)
    {
        $this->sort = PlaceSort::tryFrom($enum_value) ?? PlaceSort::MostPopular;
    }

    public function setGenre($enum_value)
    {
        $this->genre = AssetGenre::tryFrom($enum_value) ?? AssetGenre::All;
    }

    public function render()
    {
        return view('livewire.games.search', [
            'sorts' => PlaceSort::cases(),
            'genres' => AssetGenre::cases(),
            'selected_sort' => $this->sort,
            'selected_genre' => $this->genre
        ]);
    }
}
