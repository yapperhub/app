<?php

use App\Models\Post;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new class extends Component
{
    use Toast;

    public Post $post;

    public bool $deleteModal = false;

    #[NoReturn]
    public function mount(): void
    {
        $this->post = Post::query()
            ->with('details', 'details.platform', 'tags')
            ->findOrFail(request()->route('post'));
    }

    #[NoReturn]
    public function delete(): void
    {
        $this->post->delete();

        $this->toast(
            type: 'success',
            title: 'Post is deleted!',
            description: 'The deleted post cannot be recovered.',
            redirectTo: route('posts'),
        );
    }
}; ?>

<div>
    <div class="flex justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">{{ $post->title }}</h1>
            <p class="mt-2 text-gray-600">{{ $post->created_at->format('F j, Y') }} | {{ $post->id }}</p>
            <p class="mb-2 text-gray-600">{{ $post->canonical_url }}</p>
            @foreach ($post->tags as $tag)
                <span
                    class="mr-2 mt-4 inline-block rounded-full bg-gray-200 px-3 py-1 text-sm font-semibold text-gray-700"
                >
                    {{ $tag->name }}
                </span>
            @endforeach
        </div>
        <x-mary-button
            label="Delete"
            @click="$wire.deleteModal = true"
            class="btn-sm ml-2 bg-red-500 text-white hover:bg-black"
        />
    </div>

    <div class="mt-12">
        @foreach ($post->details as $details)
            <div class="">
                <h2 class="text-xl font-semibold text-gray-900">{{ $details->platform->name }}</h2>
                <hr class="mb-2 mt-2" />

                <div class="flex flex-row items-center justify-between gap-10">
                    <div class="flex flex-row items-center gap-5">
                        <img
                            src="{{ filter_var($details->featured_image, FILTER_VALIDATE_URL) ? $details->featured_image : url('storage/' . $details->featured_image) }}"
                            alt="{{ $post->title }}"
                            class="h-20 w-20 rounded-full object-cover"
                        />
                        <div class="mt-4 flex flex-col gap-3">
                            <span class="">
                                @if ($details->isPublished())
                                    <x-mary-badge value="Published: {!! $details->published_at->format('F j, Y') !!}" class="badge-primary" />
                                @else
                                    <x-mary-badge value="Draft" class="badge-warning" />
                                @endif
                            </span>
                            <span>{!! $details->excerpt !!}</span>
                            <x-mary-badge value="updated: {!! $details->updated_at->format('F j, Y') !!}" class="badge-info" />
                        </div>
                    </div>

                    <x-primary-link
                        wire:navigate
                        href="{{ route('posts.edit', ['post' => $post->id, 'platform' => $details->platform->slug]) }}"
                        class="btn btn-primary btn-sm mt-3 w-1/12 text-white"
                    >
                        Edit
                    </x-primary-link>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Delete Modal --}}
    <x-mary-modal wire:model="deleteModal" title="Delete Post" subtitle="Are you sure you want to delete this post?">
        <div><p>Are you sure you want to delete this post? This action cannot be undone.</p></div>
        <x-slot:actions>
            <x-mary-button label="Cancel" @click="$wire.deleteModal = false" />
            <x-mary-button label="Delete" class="bg-red-600 text-white hover:bg-red-700" wire:click="delete" />
        </x-slot>
    </x-mary-modal>
</div>
