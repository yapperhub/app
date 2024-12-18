<?php

use App\Livewire\Forms\PostForm;
use App\Models\Post;
use App\Models\PostDetail;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Volt\Component;

new class extends Component
{
    public PostForm $form;

    public Post $post;

    public PostDetail $postDetails;

    public string $platform;

    #[NoReturn]
    public function mount(): void
    {
        $this->post = Post::findOrFail(request()->route('post'));
        $this->postDetails = $this->post->platformDetails(request()->route('platform'))->first();
        $this->platform = request()->route('platform');

        $this->form->title = $this->post->title;
        $this->form->excerpt = $this->postDetails->excerpt;
        $this->form->featured_image = $this->postDetails->featured_image;
        $this->form->canonical_url = $this->post->canonical_url;
        $this->form->isPublished = $this->postDetails->isPublished();
        $this->form->content = $this->postDetails->content;
    }

    public function submit(): Livewire\Features\SupportRedirects\Redirector
    {
        $post = $this->form->update($this->post, $this->postDetails);

        return redirect(route('posts.edit', [
            'post' => $post->id,
            'platform' => $this->platform,
        ]));
    }
}; ?>

<div>
    <link rel="stylesheet" href="./partials/preview.css" />

    <form wire:submit.prevent="submit">
        <div class="container mx-auto mt-4 text-lg">
            @include('livewire.posts.partials.fields')
            <div class="mt-4 flex w-1/2 justify-start">
                <x-primary-button type="submit">Update</x-primary-button>
            </div>
        </div>
    </form>
</div>
