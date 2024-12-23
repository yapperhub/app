<?php

use App\Models\Post;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public function with(): array
    {
        return [
            'posts' => Post::query()->where('user_id', auth()->id())->latest()->paginate(2),
            'headers' => [
                ['key' => 'title', 'label' => 'Title'],
            ],
        ];
    }
}; ?>

<div>
    <div class="mb-12 flex justify-between">
        <div>
            <form class="flex items-center gap-3">
                <input name="q" value="{{ request('q') }}" type="search" placeholder="Search posts..."
                       class="w-96 h-9 border-gray-300 focus:border-sky-500 focus:ring-sky-500 rounded-md shadow-sm"></input>
                <x-primary-button>Search</x-primary-button>
            </form>
        </div>
        <x-primary-link href="{{ route('posts.create') }}">Create Post</x-primary-link>
    </div>

    <x-mary-table :headers="$headers" :rows="$posts" no-headers with-pagination class="">
        @scope('cell_title', $post)
        <div class="border-b-2 pb-2 hover:bg-gray-50 p-3 flex justify-between items-center">
            <div>
                <div class="text-2xl">
                    {{ $post->title }}
                </div>
                <div class="mt-2">
                    {{ $post->id }} | {{ $post->canonical_url }}
                </div>
            </div>
            <div class="mr-12">
                <a href="#" class="">
                    <img src="{{ asset('img/see.png') }}" alt="see" class="h-10" title="Details">
                </a>
            </div>
        </div>
        @endscope
    </x-mary-table>
</div>
