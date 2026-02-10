<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $posts = Auth::user()
            ->posts()
            ->withCount('comments')
            ->latest()
            ->paginate(10);

        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(StorePostRequest $request)
    {
        $post = Auth::user()->posts()->create($request->validated());

        Tag::syncTags($post, (string) $request->input('tags', ''));

        return redirect()->route('admin.posts.index')
            ->with('success', 'Пост создан');
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        return view('admin.posts.edit', compact('post'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $this->authorize('update', $post);

        $post->update($request->validated());
        Tag::syncTags($post, (string) $request->input('tags', ''));

        return redirect()->route('admin.posts.index')
            ->with('success', 'Пост обновлен');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Пост удалён');
    }
}
