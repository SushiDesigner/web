<?php

namespace App\Http\Livewire\Layout;

use Livewire\Component;
use App\Models\User;

class SearchBar extends Component
{
    /**
    * @var string
    */
    public $search = '';

    public function searchUsers($query)
    {
        // mimick ROBLOX behavior, max 4 users
        // TODO: friendship comes first! ❤💛💚💙💜
        $users = User::search($query)->take(4)->get();
        return $users;
    }
    
    public function render()
    {
        $users = $this->searchUsers($this->search);
        return view('livewire.layout.search-bar')->with('users', $users);
    }
}