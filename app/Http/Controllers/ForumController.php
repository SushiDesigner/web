<?php

namespace App\Http\Controllers;

use App\Models\ForumCategory;
use App\Models\ForumThread;
use App\Models\ForumReply;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    public function index(Request $request)
    {
        $categories = ForumCategory::orderBy('priority', 'desc')->get();
        return view('forum.index')->with('categories', $categories);
    }

    public function category(Request $request, $id)
    {
        $category = ForumCategory::where('id', $id)->first();
        $categories = ForumCategory::orderBy('priority', 'desc')->get();
        return view('forum.category')->with(['category' => $category, 'categories' => $categories]);
    }

    public function thread(Request $request, $id)
    {
        $thread = ForumThread::where('id', $id)->first();
        $categories = ForumCategory::orderBy('priority', 'desc')->get();
        return view('forum.thread')->with(['thread' => $thread, 'categories' => $categories]);
    }
}
