<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class Search extends Component
{
    use WithPagination;

    /**
     * @var string
     */
    protected $paginationTheme = 'bootstrap';

    /**
     * @var string
     */
    public $search = '';

    /**
     * @var array
     */
    public $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $users = User::search($this->search)->get();
        if (empty(trim($this->search)))
        {
            $users = $users->shuffle();
        }

        return view('livewire.users.search')->with('users', paginate($users, 12));
    }
}
