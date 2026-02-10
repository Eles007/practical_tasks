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
        if ($tag = $request->route('tag')) {
            $query->whereHas('tags', fn($q) => $q->where('name', $tag));
        }

        if ($search = $request->get('q')) {
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('content', 'like', "%{$search}%");
        }

        $posts = $query->recent()->paginate(10);

        return view('posts.index', [
            'posts' => $posts,
            'tags' => Tag::orderByDesc('frequency')->get(),
        ]);
    }

    public function show(string $slug)
    {
        $post = Post::published()
            ->where('slug', $slug)
            ->with(['tags', 'approvedComments'])
            ->firstOrFail();

        return view('posts.show', compact('post'));
    }
}
