<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $posts = Post::latest()->paginate(5);

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|min:3',
            'slug' => 'nullable',
            'excerpt' => 'required|min:10',
            'body' => 'required|min:10',
            'is_published' => 'nullable',
            'published_at' => 'nullable',
            'user_id' => 'nullable',
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $slugBase = Str::slug($data['title']);
        $slug = $slugBase . '-' . rand(1, 999999);
        $data['slug'] = $slug;

        $data['is_published'] = $request->has('is_published') == 'on';
        $data['published_at'] = $request->has('is_published') ? now() : null;

        Post::create($data);

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Пост успешно создан');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): View
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post): View
    {
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post): RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|min:3',
            'excerpt' => 'required|min:10',
            'body' => 'required|min:10',
            'is_published' => 'nullable',
            'published_at' => 'nullable',
            'user_id' => 'nullable',
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'remove_image' => ['sometimes', 'boolean'],
        ]);

        if ($request->boolean('remove_image') && $post->image) {
            Storage::disk('public')->delete($post->image);
            $data['image'] = null;
        }

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $data['is_published'] = $request->has('is_published') == 'on';
        $data['published_at'] = $request->has('is_published') ? now() : null;

        $post->update($data);

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Пост успешно обновлен');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Пост успешно удалён');
    }
}
