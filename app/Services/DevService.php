<?php

namespace App\Services;

use App\Concerns\Constants;
use App\Http\DataVault\PostVault;
use App\Models\Platform;
use Illuminate\Support\Facades\DB;
use Throwable;

class DevService
{
    public PostVault $postVault;

    public Platform $platform;

    public Platform $yapperHubPlatform;

    /**
     * @throws Throwable
     */
    public function __construct()
    {
        $this->postVault = new PostVault;
        $this->platform = $this->postVault->getPlatform(platformSlug: Constants::DEV_PLATFORM_SLUG);
        $this->yapperHubPlatform = $this->postVault->getPlatform();
    }

    /**
     * @throws Throwable
     */
    public function processPosts(array $posts, int $userId): void
    {
        foreach ($posts as $post) {
            $postSlug = $this->filterSlug(unfilteredSlug: $post['slug']);

            if ($this->postVault->postExists(userId: $userId, value: $postSlug)) {
                continue;
            }

            if ($this->postVault->postExists(userId: $userId, value: $post['canonical_url'], colum: 'canonical_url')) {
                continue;
            }

            DB::beginTransaction();

            try {
                $createdPost = $this->postVault->createPost(
                    title: $post['title'],
                    slug: $postSlug,
                    canonicalUrl: $post['canonical_url'],
                    userId: $userId,
                    source: Constants::DEV_PLATFORM_SLUG,
                );

                if (isset($post['tag_list'])) {
                    $createdPost->tags()->sync($this->postVault->tagNameToId(tags: $post['tag_list']));
                }

                $filteredMarkdown = $this->filterMarkdown(unfilteredMarkdown: $post['body_markdown']);

                // creating post-details for yapper hub
                $this->postVault->createPostDetails(
                    postId: $createdPost->id,
                    content: $filteredMarkdown,
                    platformId: $this->yapperHubPlatform->id,
                    excerpt: $post['description'],
                    featuredImage: $post['cover_image'],
                    externalId: $createdPost->id,
                    publishedAt: $post['published'] ? $post['published_at'] : null,
                );

                // creating post-details for dev.to
                $this->postVault->createPostDetails(
                    postId: $createdPost->id,
                    content: $filteredMarkdown,
                    platformId: $this->platform->id,
                    excerpt: $post['description'],
                    featuredImage: $post['cover_image'],
                    externalId: $post['id'],
                    publishedAt: $post['published'] ? $post['published_at'] : null,
                );

                DB::commit();
            } catch (Throwable $e) {
                // dump($e->getMessage());
                DB::rollBack();
            }
        }
    }

    private function filterSlug(string $unfilteredSlug): string
    {
        return implode('-', array_slice(explode('-', $unfilteredSlug), 0, -1));
    }

    private function filterMarkdown(string $unfilteredMarkdown): string
    {
        return preg_replace('/---(.|\n)*---/', '', $unfilteredMarkdown);
    }
}
