<?php

namespace App\Concerns;

use App\Models\Platform;
use App\Models\PostDetail;
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

    public function createPostUrl(string $postSlug): \Illuminate\Foundation\Application
    {
        return url("post/{$postSlug}-{$this->uniqueString()}");
    }

    public function uniqueString(int $length = 5): string
    {
        return Str::random($length);
    }

    public function tagNameToId(array $tags): array
    {
        $tagIds = [];
        foreach ($tags as $tag) {
            $tagIds[] = Tag::firstOrCreate(['name' => Str::slug($tag)])->id;
        }

        return $tagIds;
    }

    public function postExists(int $userId, string $value, string $colum = 'slug'): bool
    {
        return \App\Models\Post::query()->where('user_id', $userId)->where($colum, $value)->exists();
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

    public function createPostDetails(
        string $postId,
        string $content,
        string $platformId,
        ?string $excerpt,
        ?string $featuredImage,
    ) {
        return PostDetail::query()->create([
            'post_id' => $postId,
            'excerpt' => $excerpt,
            'featured_image' => $featuredImage,
            'content' => $content,
            'platform_id' => $platformId,
        ]);
    }
}
