<?php

use App\Models\Post;
use App\Models\PostDetail;
use Livewire\Volt\Component;

new class extends Component
{
    public function with(): array
    {
        return [
            'posts' => Post::query()
                ->where('user_id', auth()->id())
                ->count(),
            'published_posts' => PostDetail::query()
                ->whereHas('post', fn ($query) => $query->where('user_id', auth()->id()))
                ->isPublished()
                ->count(),
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
    </div>
</div>
