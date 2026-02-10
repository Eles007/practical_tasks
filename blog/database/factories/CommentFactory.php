<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Comment>
 */
class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        return [
            'post_id' => Post::factory(),
            'author' => fake()->name(),
            'email' => fake()->safeEmail(),
            'url' => fake()->optional()->url(),
            'content' => fake()->sentence(12),
            'status' => fake()->randomElement(['pending', 'approved']),
        ];
    }
}
