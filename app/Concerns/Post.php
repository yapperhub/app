<?php

namespace App\Concerns;

use App\Models\Platform;
use Exception;
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
}
