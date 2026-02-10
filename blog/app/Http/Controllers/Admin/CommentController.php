<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $comments = Comment::with('post')
            ->latest()
            ->paginate(15);

        return view('admin.comments.index', compact('comments'));
    }

    public function approve(Comment $comment)
    {
        $comment->update(['status' => 'approved']);

        return back()->with('success', 'Комментарий одобрен');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return back()->with('success', 'Комментарий удалён');
    }
}
