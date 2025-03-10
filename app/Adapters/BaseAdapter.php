<?php

namespace App\Adapters;

use App\Models\Log;

class BaseAdapter
{
    protected function logEntry(
        array $request,
        array $response,
        int $userId,
        ?string $platformId
    ): void {
        Log::query()->create([
            'user_id' => $userId,
            'platform_id' => $platformId,
            'method' => $request['method'],
            'url' => $request['url'],
            'response_status_code' => $response['status_code'],
            'response_time' => $response['time'],
            'user_agent' => $request['headers']['User-Agent'],
            'ip_address' => $request['headers']['X-Forwarded-For'],
            'request' => json_encode($request),
            'response' => json_encode($response),
        ]);
    }
}
