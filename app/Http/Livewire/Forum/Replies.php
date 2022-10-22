<?php

namespace App\Http\Livewire\Forum;

use App\Models\ForumCategory;
use App\Models\ForumThread;
use App\Models\ForumReply;
use App\Roles\Forums;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Replies extends Component
{
    use WithPagination;

    /**
     * @var string
     */
    protected $paginationTheme = 'bootstrap';

    public $thread;

    public function render()
    {
        $replies = ForumReply::where('thread_id', '=', $this->thread->id)->orderBy('created_at', 'desc')->get();

        return view('livewire.forum.replies')->with('replies', paginate($replies, 10));
    }
}