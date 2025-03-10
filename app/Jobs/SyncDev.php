<?php

namespace App\Jobs;

use App\Adapters\DevAdapter;
use App\Services\DevService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Throwable;

class SyncDev implements ShouldQueue
{
    use Queueable;

    private int $userId;

    private string $apiKey;

    /**
     * Create a new job instance.
     */
    public function __construct(int $userId, string $apiKey)
    {
        $this->userId = $userId;
        $this->apiKey = $apiKey;
    }

    /**
     * Execute the job.
     *
     * @throws Throwable
     */
    public function handle(DevAdapter $devAdapter, DevService $devService): void
    {
        $devPosts = $devAdapter->posts(apiKey: $this->apiKey, userId: $this->userId);

        if (! $devPosts['status']) {
            return;
        }

        $devService->processPosts(posts: $devPosts['data'], userId: $this->userId);
    }
}
