<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TagController extends Controller
{
    public function show(Request $request, Tag $tag): View
    {
        $postsQuery = $tag->posts()
            ->where('is_published', true)
            ->where('is_approved', true)
            ->with(['tags']);

        if ($search = trim((string)$request->get('q'))) {
            $postsQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('body', 'like', "%{$search}%");
            });
        }

        $posts = $postsQuery
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->paginate(4)
            ->withQueryString();

        return view('posts.index', [
            'posts' => $posts,
            'tag' => $tag,
        ]);
    }
}

