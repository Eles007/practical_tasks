<?php

namespace App\Service;


use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostService
{
    public function create(array $data): Post
    {
        return DB::transaction(function () use ($data) {
            $image = $data['image'] ?? null;
            $tagsInput = $data['tags'] ?? null;
            unset($data['image'], $data['remove_image']);
            unset($data['tags']);

            $slugBase = Str::slug($data['title']);
            $slug = $slugBase . '-' . rand(1, 999999);
            $data['slug'] = $slug;

            $isPublished = (bool)($data['is_published'] ?? false);
            $data['is_published'] = $isPublished;
            $isApproved = (bool)($data['is_approved'] ?? false);
            $data['is_approved'] = $isApproved;
            $data['published_at'] = $isPublished ? now() : null;

            $post = Post::create($data);

            if ($image) {
                $path = $image->store('posts', 'public');
                $post->image = $path;
                $post->save();
            }

            $this->syncTags($post, $tagsInput);

            return $post;
        });
    }

    public function update(Post $post, array $data): Post
    {
        return DB::transaction(function () use ($post, $data) {
            $newImage = $data['image'] ?? null;
            $removeImage = (bool)($data['remove_image'] ?? false);
            $tagsInput = $data['tags'] ?? null;
            unset($data['image'], $data['remove_image']);
            unset($data['tags']);

            $wasPublished = (bool)$post->is_published;
            $nowPublished = (bool)($data['is_published'] ?? $wasPublished);
            $data['is_published'] = $nowPublished;

            $data['is_approved'] = (bool)($data['is_approved'] ?? $post->is_approved);

            if (!$wasPublished && $nowPublished) {
                $data['published_at'] = now();
            } elseif ($wasPublished && !$nowPublished) {
                $data['published_at'] = null;
            }

            $slugBase = Str::slug($data['title']);
            $slug = $slugBase . '-' . rand(1, 999999);
            $data['slug'] = $slug;

            $post->update($data);

            if ($removeImage && $post->image) {
                Storage::disk('public')->delete($post->image);
                $post->image = null;
            }

            if ($newImage) {
                if ($post->image) {
                    Storage::disk('public')->delete($post->image);
                }
                $post->image = $newImage->store('posts', 'public');
            }

            $post->save();

            $this->syncTags($post, $tagsInput);

            return $post;
        });
    }

    public function delete(Post $post): void
    {
        DB::transaction(function () use ($post) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $post->delete();
        });
    }

    private function syncTags(Post $post, string|array|null $tagsInput): void
    {
        $names = is_array($tagsInput)
            ? $tagsInput
            : (preg_split('/[,\n;]/u', (string)$tagsInput) ?: []);

        $names = collect($names)
            ->map(fn($t) => trim((string)$t))
            ->filter()
            ->unique()
            ->take(30)
            ->values();

        if ($names->isEmpty()) {
            $post->tags()->sync([]);
            return;
        }

        $tagIds = [];
        foreach ($names as $name) {
            $slug = Str::slug($name);
            if ($slug === '') {
                continue;
            }

            $tag = Tag::query()->firstOrCreate(
                ['slug' => $slug],
                ['name' => $name]
            );

            $tagIds[] = $tag->id;
        }

        $post->tags()->sync(array_values(array_unique($tagIds)));
    }
}
