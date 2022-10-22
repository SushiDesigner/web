<?php

namespace App\Http\Livewire\Forum;

use App\Models\ForumCategory;
use App\Models\ForumThread;
use App\Models\ForumReply;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Http\Request;

class Threads extends Component
{
    use WithPagination;

    public $category;

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

    public function render()
    {
        $threads = [];

        if ($this->search) {
            $threads = ForumThread::search($this->search)->get();
        } elseif ($this->category) {
            $threads = ForumThread::where('category_id', '=', $this->category->id)->orderBy('updated_at', 'desc')->get();
        } else {
            $threads = ForumThread::orderBy('updated_at', 'desc')->get();
        }

        return view('livewire.forum.threads')->with('threads', paginate($threads, 10));
    }
}
