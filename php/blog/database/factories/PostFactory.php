<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(mt_rand(5, 8));

        $slugBase = Str::slug($title);
        $slug = $slugBase . '-' . $this->faker->unique()->numberBetween(1000, 999999);

        return [
            'title' => $title,
            'slug' => $slug,
            'excerpt' => $this->faker->paragraph(mt_rand(2, 4)),
            'body' => collect(range(1, mt_rand(2, 4)))
                ->map(fn() => $this->faker->paragraph(mt_rand(3, 6)))
                ->implode('\n\n'),
            'is_published' => $this->faker->boolean(70),
            'published_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'user_id' => null
        ];
    }
}
