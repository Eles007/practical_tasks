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
        return $this->belongsToMany(Post::class)->withTimestamps();
    }

    public static function syncTags(Post $post, string $tagString): void
    {
        $names = collect(
            preg_split('/\s*,\s*/', strtolower($tagString), -1, PREG_SPLIT_NO_EMPTY)
        )->unique();

        $tagIds = [];

        foreach ($names as $name) {
            $tag = static::firstOrCreate(['name' => $name]);
            $tagIds[] = $tag->id;
        }

        // update frequency
        $old = $post->tags->pluck('id')->toArray();

        $post->tags()->sync($tagIds);

        static::whereIn('id', array_diff($tagIds, $old))
            ->increment('frequency');

        static::whereIn('id', array_diff($old, $tagIds))
            ->decrement('frequency');
    }
}
