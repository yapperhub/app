<?php

namespace App\Http\DataVault;

use App\Concerns\Constants;
use App\Models\Platform;
use App\Models\Post;
use App\Models\PostDetail;
use App\Models\Tag;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Throwable;

class PostVault
{
    public function postCount(int $userId): int
    {
        return Post::query()->where('user_id', $userId)->count();
    }

    public function publishedPostCount(int $userId): int
    {
        return PostDetail::query()
            ->whereHas('post', fn ($query) => $query->where('user_id', auth()->id()))
            ->isPublished()
            ->count();
    }

    public function postsPaginated(int $userId, ?string $search, int $perPage = 20): LengthAwarePaginator
    {
        return Post::query()
            ->where('user_id', $userId)
            ->latest()
            ->when($search, fn ($query, $q) => $query->where('title', 'like', "%$q%"))
            ->with('tags')
            ->paginate($perPage);
    }

    public function postExists(int $userId, string $value, string $colum = 'slug'): bool
    {
        return Post::query()->where('user_id', $userId)->where($colum, $value)->exists();
    }

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

    public function tagNameToId(array $tags): array
    {
        $tagIds = [];
        foreach ($tags as $tag) {
            $tagIds[] = Tag::firstOrCreate(['name' => Str::slug($tag)])->id;
        }

        return $tagIds;
    }

    public function createPost(
        string $title,
        string $slug,
        string $canonicalUrl,
        int $userId,
        string $source = 'web',
    ) {
        return Post::query()->create([
            'title' => $title,
            'canonical_url' => $canonicalUrl,
            'slug' => $slug,
            'user_id' => $userId,
            'source' => $source,
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
