<?php

use Livewire\Volt\Component;

new class extends Component
{
    public string $title = '';

    public string $excerpt = '';

    public string $featured_image = '';

    public function createPost(): void
    {
        $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['required', 'string', 'max:255'],
            'featured_image' => ['nullable', 'string'],
        ]);
    }
}; ?>

<div>
    <form wire:submit.prevent="createPost">
        <div class="container mx-auto mt-4 text-lg">
            @include('livewire.posts.partials.fields')

            <div class="mt-12 flex w-1/2 justify-start">
                <x-primary-button>Save</x-primary-button>
            </div>
        </div>
    </form>
</div>
