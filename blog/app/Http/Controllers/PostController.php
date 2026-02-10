<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::published()->with('tags', 'user');

        if ($tag = $request->string('tag')->toString()) {
            $query->whereHas('tags', fn ($q) => $q->where('name', $tag));
        }

        if ($search = $request->string('q')->toString()) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $posts = $query->recent()->paginate(10)->withQueryString();

        return view('posts.index', [
            'posts' => $posts,
            'tags' => Tag::orderByDesc('frequency')->limit(20)->get(),
            'activeTag' => $tag ?: null,
            'search' => $search ?: null,
        ]);
    }

    public function show(string $slug)
    {
        $post = Post::published()
            ->where('slug', $slug)
            ->with(['tags', 'user', 'approvedComments'])
            ->firstOrFail();

        return view('posts.show', compact('post'));
    }
}
