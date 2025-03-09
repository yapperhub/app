<?php

use App\Livewire\Forms\PostForm;
use App\Models\Post;
use App\Models\PostDetail;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;

new class extends Component
{
    use Toast, WithFileUploads;

    public PostForm $form;

    public Post $post;

    public PostDetail $postDetails;

    public string $image_url = '';

    public bool $publishModal = false;

    public bool $unPublishModal = false;

    public bool $isPublished = false;

    #[NoReturn]
    public function mount(): void
    {
        $this->post = Post::findOrFail(request()->route('post'));
        $this->postDetails = $this->post->platformDetails(request()->route('platform'))->first();

        $this->form->title = $this->post->title;
        $this->form->excerpt = $this->postDetails->excerpt;
        $this->image_url = filter_var($this->postDetails->featured_image, FILTER_VALIDATE_URL)
            ? $this->postDetails->featured_image
            : url('storage/' . $this->postDetails->featured_image);
        $this->form->canonical_url = $this->post->canonical_url;
        $this->isPublished = $this->postDetails->isPublished();
        $this->form->content = $this->postDetails->content;
        $this->form->tags = $this->post->tags->pluck('name')->toArray();
    }

    public function submit(): void
    {
        $post = $this->form->update($this->post, $this->postDetails);

        $this->toast(type: 'success', title: 'Post updated!');
    }

    public function publish(): void
    {
        if ($this->form->published_at === null) {
            $this->toast(type: 'error', title: 'Publish date is required.');

            return;
        }

        $this->form->publish($this->postDetails);
        $this->isPublished = true;
        $this->publishModal = false;

        $this->toast(type: 'success', title: 'Post published!');
    }

    public function unpublish(): void
    {
        $this->form->unpublish($this->postDetails);
        $this->isPublished = false;
        $this->unPublishModal = false;

        $this->toast(type: 'success', title: 'Post unpublished!');
    }
}; ?>

<div>
    <form wire:submit.prevent="submit">
        <div class="container mx-auto mt-4 text-lg">

            @include('livewire.posts.partials.fields')

            <div class="flex flex-row justify-between mt-4 ">
                <div class="flex w-1/2 justify-start">
                    <x-primary-button type="submit">Update</x-primary-button>
                    @if ($this->isPublished)
                        <x-mary-button
                            label="Unpublish"
                            @click="$wire.unPublishModal = true"
                            class="btn-sm ml-2 bg-red-500 text-white hover:bg-black"
                        />
                    @else
                        <x-mary-button
                            label="Publish"
                            @click="$wire.publishModal = true"
                            class="btn-sm ml-2 bg-primary text-white hover:bg-black"
                        />
                    @endif
                </div>
                <x-secondary-button onclick="window.history.back()">Cancel</x-secondary-button>
            </div>
        </div>
    </form>

    {{-- Modal for publish action. --}}
    <x-mary-modal wire:model="publishModal" title="Publish" subtitle="Publish Post" separator>
        <div>
            <x-mary-datepicker
                label="Publish Date"
                required="true"
                wire:model="form.published_at"
                icon="o-calendar"
                hint="This post will be published on the selected date."
            />
        </div>
        <x-slot:actions>
            <x-mary-button label="Cancel" @click="$wire.publishModal = false" />
            <x-mary-button label="Confirm" class="bg-primary text-white hover:bg-black" wire:click="publish" />
        </x-slot>
    </x-mary-modal>

    {{-- Modal for unpublish action. --}}
    <x-mary-modal wire:model="unPublishModal" title="Unpublish" subtitle="Unpublish Post" separator>
        <div><p>Are you sure you want to unpublish this post?</p></div>
        <x-slot:actions>
            <x-mary-button label="Cancel" @click="$wire.unPublishModal = false" />
            <x-mary-button label="Confirm" class="bg-red-600 text-white hover:bg-red-700" wire:click="unpublish" />
        </x-slot>
    </x-mary-modal>
</div>
