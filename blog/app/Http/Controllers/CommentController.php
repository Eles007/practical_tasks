<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Post;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, string $slug)
    {
        $post = Post::published()->where('slug', $slug)->firstOrFail();

        $post->comments()->create($request->validated());

        return back()->with('success', 'Комментарий отправлен и ожидает модерации');
    }
}
