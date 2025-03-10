<?php

namespace App\Adapters;

use App\Concerns\Constants;
use App\Concerns\Interfaces\AdapterInterface;
use App\Models\Platform;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class DevAdapter extends BaseAdapter implements AdapterInterface
{
    private const BASE_ARTICLE_URL = 'https://dev.to/api/articles/';

    public function posts(string $apiKey, int $userId): Collection
    {
        $url = self::BASE_ARTICLE_URL . 'me?page=1&per_page=1000';

        $request = [
            'method' => 'GET',
            'url' => $url,
            'headers' => [
                'api-key' => $apiKey,
                'User-Agent' => request()->userAgent(),
                'X-Forwarded-For' => request()->ip(),
            ],
        ];

        $startTime = microtime(true);

        try {
            $posts = Http::withHeaders(['api-key' => $apiKey])->get($url);

            $response = [
                'status_code' => $posts->status(),
                'time' => microtime(true) - $startTime,
                'json' => $posts->json(),
            ];

            $this->logEntry(request: $request, response: $response, userId: $userId, platformId: $this->platform()->id);

            return collect([
                'status' => true,
                'data' => $posts->json(),
            ]);
        } catch (Exception $e) {
            $response = [
                'status_code' => $e->getCode(),
                'error' => $e->getMessage(),
                'time' => microtime(true) - $startTime,
                'json' => [],
            ];

            $this->logEntry(request: $request, response: $response, userId: $userId, platformId: $this->platform()->id);

            return collect([
                'status' => false,
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);
        }
    }

    public function filterSlug(string $unfilteredSlug): string
    {
        return implode('-', array_slice(explode('-', $unfilteredSlug), 0, -1));
    }

    private function platform()
    {
        return Platform::query()->where('slug', Constants::DEV_PLATFORM_SLUG)->first();
    }
}
