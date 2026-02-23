<?php

namespace App\Services;

use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Services\Interfaces\PostServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class PostService implements PostServiceInterface
{
    public function __construct(
        private PostRepositoryInterface $postRepository,
    ) {
    }

    public function getAllApi(): Collection
    {
        return $this->postRepository->allApi();
    }

    public function getByIdApi(int $id): ?Post
    {
        return $this->postRepository->findApi($id);
    }

    public function createApi(array $data): Post
    {
        $slug = Str::slug($data['title']);
        $data['slug'] = $slug;
        return $this->postRepository->createApi($data);
    }

    public function updateApi(int $id, array $data): ?Post
    {
        $post = $this->postRepository->findApi($id);
        if (!$post) {
            return null;
        }

        return $this->postRepository->updateApi($post, $data);
    }

    public function deleteApi(int $id): bool
    {
        $post = $this->postRepository->findApi($id);
        if (!$post) {
            return false;
        }
        return $this->postRepository->deleteApi($post);
    }
}
