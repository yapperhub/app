<?php

use App\Concerns\Constants;
use App\Livewire\Forms\PostForm;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;

new class extends Component
{
    use Toast, WithFileUploads;

    public PostForm $form;

    public function submit(): void
    {
        $post = $this->form->store();

        $this->toast(
            type: 'success',
            title: 'Post is created!',
            description: 'You can now edit the post.',
            position: 'toast-top toast-end',
            timeout: 4000,
            redirectTo: route('posts.edit', [
                'post' => $post->id,
                'platform' => Constants::YAPPER_HUB_PLATFORM_SLUG,
            ]),
        );
    }
}; ?>

<div>
    <link rel="stylesheet" href="./partials/preview.css" />

    <form wire:submit.prevent="submit">
        <div class="container mx-auto mt-4 text-lg">
            @include('livewire.posts.partials.fields')
            <div class="mt-4 flex w-1/2 justify-start">
                <x-primary-button type="submit">Save</x-primary-button>
            </div>
        </div>
    </form>
</div>
