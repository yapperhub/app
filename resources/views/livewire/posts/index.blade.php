<?php

use App\Http\DataVault\PostVault;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public function with(PostVault $postVault): array
    {
        return [
            'posts' => $postVault->postsPaginated(userId: auth()->id(), search: request('q')),
            'headers' => [['key' => 'title', 'label' => 'Title']],
        ];
    }
}; ?>

<div>
    <div class="mb-12 flex items-center justify-between">
        <div>
            <form class="flex items-center gap-3">
                <input
                    name="q"
                    value="{{ request('q') }}"
                    type="search"
                    placeholder="Search posts..."
                    class="h-9 w-96 rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500"
                />
                <x-primary-button>Search</x-primary-button>
            </form>
        </div>
        <x-primary-link href="{{ route('posts.create') }}">Create Post</x-primary-link>
    </div>

    <x-mary-table
        :headers="$headers"
        :rows="$posts"
        per-page="perPage"
        :per-page-values="[20, 30, 50, 100]"
        no-headers
        with-pagination
    >
        @scope('cell_title', $post)
            <div class="flex items-center justify-between border-b-2 pb-5">
                <div>
                    <div class="text-2xl">{{ $post->title }}</div>
                    <div class="mb-1 mt-2">{{ $post->id }}</div>
                    <div class="mb-3 mt-2">{{ $post->canonical_url }}</div>
                    @foreach ($post->tags as $tag)
                        <span
                            class="mr-2 mt-2 inline-block rounded-full bg-gray-200 px-3 py-1 text-sm font-semibold text-gray-700"
                        >
                            {{ $tag->name }}
                        </span>
                    @endforeach
                </div>

                <x-secondary-link href="{{ route('posts.show', ['post' => $post->id]) }}">Details</x-secondary-link>
            </div>
        @endscope
    </x-mary-table>
</div>
