<?php

namespace App\Http\Livewire\Forum;

use App\Models\ForumCategory;
use App\Models\ForumThread;
use App\Models\ForumReply;
use App\Roles\Forums;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Thread extends Component
{
    public $thread;

    public function render()
    {
        return view('livewire.forum.thread')->with('thread', $this->thread);
    }

    public function delete()
    {
        if (Auth::user()->may(Forums::roleset(), Forums::GLOBAL_DELETE_POSTS)) {
            $this->thread->delete();

            return redirect(route('forum'));
        }
    }
}
