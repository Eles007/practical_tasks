<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Services\Interfaces\PostServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
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

    public function getTrashed(): Collection
    {
        return Cache::remember('posts_trash', 60, function () {
            return $this->postRepository->getTrashed();
        });
    }

    public function getByIdApi(int $id): ?Post
    {
        return Cache::remember("posts_{$id}", 60, function () use ($id) {
            $post = $this->postRepository->findApi($id);

            if (!$post) {
                throw new ApiException("Post with id $id not found", 404);
            }

            return $post;
        });
    }

    public function createApi(array $data): Post
    {
        $slug = Str::slug($data['title']);
        $data['slug'] = $slug;
        $post = $this->postRepository->createApi($data);

        Log::info("Post created", [
            'post_id' => $post->id,
            'user_id' => $post->user_id,
        ]);

        Cache::forget('posts_all');
        Cache::forget("posts_{$post->id}");

        $id = $post->id;

        return Cache::tags(['posts'])->remember("post_{$id}", 120, function () use ($id) {
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

    public function softDeleteApi(int $id): bool
    {
        $post = $this->postRepository->findApi($id);
        if (!$post) {
            return false;
        }
        $deletedPost = $this->postRepository->softDelete($post);
        Cache::forget('posts_all');
        Cache::forget("post_{$id}");
        return $deletedPost;
    }

    public function restoreApi(int $id): ?Post
    {
        $post = $this->postRepository->restore($id);
        if (!$post) {
            return null;
        }

        Cache::forget('posts_all');
        Cache::forget("post_{$id}");

        return $post;
    }

    public function forceDeleteApi(int $id): bool
    {
        $deleted = $this->postRepository->forceDelete($id);
        if (!$deleted) {
            return false;
        }
        Cache::forget('posts_all');
        Cache::forget("post_{$id}");
        return true;
    }
}
