<?php

namespace App\Http\DataVault;

use App\Models\Post;
use App\Models\PostDetail;

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
}
