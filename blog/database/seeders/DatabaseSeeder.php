<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        $users = User::factory(4)->create();
        $allUsers = $users->prepend($admin);

        $tags = Tag::factory()->count(12)->create();

        $allUsers->each(function (User $user) use ($tags) {
            $posts = Post::factory()
                ->count(5)
                ->for($user)
                ->state(fn () => ['status' => fake()->randomElement(['published', 'published', 'draft'])])
                ->create();

            $posts->each(function (Post $post) use ($tags) {
                $selectedTags = $tags->random(rand(1, 4));
                $post->tags()->sync($selectedTags->pluck('id')->all());

                Comment::factory()->count(rand(0, 5))->for($post)->create();
            });
        });

        Tag::query()->each(function (Tag $tag) {
            $tag->update(['frequency' => $tag->posts()->count()]);
        });
    }
}
