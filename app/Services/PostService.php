<?php

namespace App\Services;

use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Services\Interfaces\PostServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class PostService implements PostServiceInterface
{
    public function __construct(
        private PostRepositoryInterface $postRepository,
    ) {
    }

    public function getAllApi(): Collection
    {
        return Cache::remember('posts_all', 60, function () {
            return $this->postRepository->allApi();
        });
    }

    public function getByIdApi(int $id): ?Post
    {
        return Cache::remember("posts_{$id}", 60, function () use ($id) {
            return $this->postRepository->findApi($id);
        });
    }

    public function createApi(array $data): Post
    {
        $slug = Str::slug($data['title']);
        $data['slug'] = $slug;
        $post = $this->postRepository->createApi($data);

        Cache::forget('posts_all');

        $id = $post->id;

        Cache::tags(['posts'])->remember("post_{$id}", 120, function () use ($id) {
            return $this->postRepository->findApi($id);
        });
    }

    public function updateApi(int $id, array $data): ?Post
    {
        $post = $this->postRepository->findApi($id);
        if (!$post) {
            return null;
        }
        $slug = Str::slug($data['title']);
        $data['slug'] = $slug;
        $updatedPost = $this->postRepository->updateApi($post, $data);

        Cache::forget('posts_all');
        return $updatedPost;
    }

    public function deleteApi(int $id): bool
    {
        $post = $this->postRepository->findApi($id);
        if (!$post) {
            return false;
        }
        $deletedPost = $this->postRepository->deleteApi($post);
        Cache::forget('posts_all');
        return $deletedPost;
    }
}
