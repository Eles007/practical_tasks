<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, Post $post): RedirectResponse
    {
        if (!$post->is_published) {
            abort(404);
        }

        Comment::create([
            'post_id' => $post->id,
            'user_id' => $request->user()?->id,
            'author_name' => $request->user()?->name ?? $request->validated('author_name'),
            'body' => $request->validated('body'),
            'is_approved' => true,
        ]);

        return back()->with('status', 'Комментарий добавлен.');
    }
}

