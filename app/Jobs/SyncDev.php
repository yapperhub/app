<?php

namespace App\Jobs;

use App\Adapters\DevAdapter;
use App\Http\DataVault\PostVault;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

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
     */
    public function handle(DevAdapter $devAdapter, PostVault $postVault): void
    {
        $devPosts = $devAdapter->posts(apiKey: $this->apiKey, userId: $this->userId);

        if (! $devPosts['status']) {
            return;
        }

        foreach ($devPosts['data'] as $post) {
            $postSlug = $devAdapter->filterSlug(unfilteredSlug: $post['slug']);

            $ifExist = $postVault->postExists(userId: $this->userId, value: $postSlug);

            if ($ifExist) {
                continue;
            }

            $ifExist = $postVault->postExists(userId: $this->userId, value: $post['canonical_url'], colum: 'canonical_url');

            if ($ifExist) {
                continue;
            }
        }

        // Process the posts
    }
}
