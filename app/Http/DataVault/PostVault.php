<?php

namespace App\Http\DataVault;

use App\Models\Post;
use App\Models\PostDetail;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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
}
