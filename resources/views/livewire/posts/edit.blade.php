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

    public string $platform;

    public string $image_url = '';

    #[NoReturn]
    public function mount(): void
    {
        $this->post = Post::findOrFail(request()->route('post'));
        $this->postDetails = $this->post->platformDetails(request()->route('platform'))->first();
        $this->platform = request()->route('platform');

        $this->form->title = $this->post->title;
        $this->form->excerpt = $this->postDetails->excerpt;
        $this->image_url = url('storage/' . $this->postDetails->featured_image);
        $this->form->canonical_url = $this->post->canonical_url;
        $this->form->isPublished = $this->postDetails->isPublished();
        $this->form->content = $this->postDetails->content;
    }

    public function submit(): void
    {
        $post = $this->form->update($this->post, $this->postDetails);

        $this->toast(type: 'success', title: 'Post is updated!', position: 'toast-top toast-end', timeout: 4000);
    }
}; ?>

<div>
    <link rel="stylesheet" href="{{ url('css/editor-preview.css') }}" />

    <form wire:submit.prevent="submit">
        <div class="container mx-auto mt-4 text-lg">
            @include('livewire.posts.partials.fields')
            <div class="mt-4 flex w-1/2 justify-start">
                <x-primary-button type="submit">Update</x-primary-button>
            </div>
        </div>
    </form>
</div>
