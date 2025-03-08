<?php

use App\Http\DataVault\ApiStatsVault;
use App\Http\DataVault\PostVault;
use Livewire\Volt\Component;

new class extends Component
{
    public array $apiStats;

    public function with(ApiStatsVault $apiStatsVault, PostVault $postVault): array
    {
        $this->apiStats = $apiStatsVault->chart(apiStatsArray: $apiStatsVault->handle(userId: auth()->id()));

        return [
            'posts' => $postVault->postCount(userId: auth()->id()),
            'published_posts' => $postVault->publishedPostCount(userId: auth()->id()),
        ];
    }
}; ?>

<div>
    <div class="container mx-auto mt-4 text-lg sm:px-6 lg:px-8">
        <div class="flex gap-2">
            <div class="w-1/12">
                <x-mary-stat
                    title="Posts"
                    value="{{ $posts }}"
                    icon="o-clipboard-document-list"
                    tooltip="Total Posts"
                />
            </div>
            <div class="w-2/12">
                <x-mary-stat
                    title="Published Posts (YapperHub)"
                    value="{{ $published_posts }}"
                    icon="o-clipboard-document-list"
                    tooltip="Total Published Posts on YapperHub"
                />
            </div>
        </div>
        <div class="mt-4 w-3/12">
            <x-mary-chart wire:model="apiStats" />
        </div>
    </div>
</div>
