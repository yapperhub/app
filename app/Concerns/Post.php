<?php

namespace App\Concerns;

use App\Models\Platform;
use App\Models\Tag;
use Exception;
use Illuminate\Support\Str;
use Throwable;

trait Post
{
    /**
     * @throws Throwable
     */
    public function getPlatform(?string $platformSlug = null): Platform
    {
        $platform = Platform::query()->where(
            'slug',
            $platformSlug === null ? Constants::YAPPER_HUB_PLATFORM_SLUG : $platformSlug
        )->first();

        throw_if($platform === null, new Exception('Platform not found'));

        return $platform;
    }

    public function createPostUrl(string $postSlug): string
    {
        return url("post/{$postSlug}-{$this->uniqueString()}");
    }

    public function uniqueString(int $length = 5): string
    {
        return Str::random($length);
    }

    public function tagNameToId(): array
    {
        $tagIds = [];
        foreach ($this->tags as $tag) {
            $tagIds[] = Tag::firstOrCreate(['name' => Str::slug($tag)])->id;
        }

        return $tagIds;
    }

    public function createPost(
        string $title,
        string $slug,
        string $canonicalUrl,
        int $userId
    ) {
        return \App\Models\Post::query()->create([
            'title' => $title,
            'canonical_url' => $canonicalUrl,
            'slug' => $slug,
            'user_id' => $userId,
        ]);
    }
}
