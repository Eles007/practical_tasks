<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use RefreshDatabase;

    public function test_posts_page_can_be_filtered_by_tag_and_search_query(): void
    {
        $user = User::factory()->create();

        $laravelTag = Tag::factory()->create(['name' => 'laravel']);
        $phpTag = Tag::factory()->create(['name' => 'php']);

        $postOne = Post::factory()->published()->for($user)->create([
            'title' => 'Laravel 12 release',
            'content' => 'Great changes for framework developers',
        ]);
        $postOne->tags()->attach($laravelTag->id);

        $postTwo = Post::factory()->published()->for($user)->create([
            'title' => 'PHP internals',
            'content' => 'Low level runtime details',
        ]);
        $postTwo->tags()->attach($phpTag->id);

        $response = $this->get(route('posts.index', ['tag' => 'laravel', 'q' => 'release']));

        $response->assertOk();
        $response->assertSee('Laravel 12 release');
        $response->assertDontSee('PHP internals');
    }

    public function test_user_cannot_edit_foreign_post(): void
    {
        $owner = User::factory()->create();
        $intruder = User::factory()->create();

        $post = Post::factory()->for($owner)->create();

        $response = $this
            ->actingAs($intruder)
            ->get(route('admin.posts.edit', $post));

        $response->assertForbidden();
    }
}
