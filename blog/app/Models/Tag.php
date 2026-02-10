<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'frequency',
    ];

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    public static function syncTags(Post $post, string $tagString): void
    {
        $names = collect(
            preg_split('/\s*,\s*/', strtolower($tagString), -1, PREG_SPLIT_NO_EMPTY)
        )
            ->map(fn (string $tag) => trim($tag))
            ->filter()
            ->unique();

        $tagIds = [];

        foreach ($names as $name) {
            $tag = static::firstOrCreate(['name' => $name]);
            $tagIds[] = $tag->id;
        }

        $old = $post->tags()->pluck('tags.id')->toArray();

        $post->tags()->sync($tagIds);

        static::whereIn('id', array_diff($tagIds, $old))->increment('frequency');

        $removedIds = array_diff($old, $tagIds);
        if ($removedIds) {
            static::whereIn('id', $removedIds)->decrement('frequency');
            static::whereIn('id', $removedIds)->where('frequency', '<', 0)->update(['frequency' => 0]);
        }
    }
}
