<?php

namespace App\Concerns;

use App\Models\Platform;
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
}
