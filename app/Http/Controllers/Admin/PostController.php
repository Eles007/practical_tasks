<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Service\PostService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PostController extends Controller
{
    public function __construct(
        private PostService $service,
        private PostRepositoryInterface $repository,
    ) {
    }

    public function index(): View
    {
        $posts = $this->repository->getPaginated(4);

        return view('admin.posts.index', compact('posts'));
    }

    public function create(): View
    {
        return view('admin.posts.create');
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        $this->service->create($request->validated());

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Пост успешно создан');
    }

    public function show(Post $post): View
    {
        return view('admin.posts.show', compact('post'));
    }

    public function edit(Post $post): View
    {
        return view('admin.posts.edit', compact('post'));
    }

    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        $this->service->update($post, $request->validated());

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Пост успешно обновлен');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $this->service->delete($post);

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Пост успешно удалён');
    }
}
