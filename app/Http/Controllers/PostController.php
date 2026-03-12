<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    public function __construct(
        private PostRepositoryInterface $posts
    ) {
    }

    public function index(Request $request): View
    {
        $posts = $this->posts->getPublishedPaginated($request->get('q'), 4);
        return view('posts.index', compact('posts'));
    }

    public function show(string $slug): View
    {
        $post = $this->posts->findPublishedBySlugOrFail($slug);

        $comments = Comment::query()
            ->where('post_id', $post->id)
            ->where('is_approved', true)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('posts.show', compact('post', 'comments'));
    }
}


