<?php

use App\Livewire\Forms\PostForm;
use Livewire\Volt\Component;

new class extends Component
{
    public PostForm $form;

    public function submit(): void
    {
        $this->form->store();

        $this->redirect(route('posts.index'));
    }
}; ?>

<div>
    <form wire:submit.prevent="submit">
        <div class="container mx-auto mt-4 text-lg">
            @include('livewire.posts.partials.fields')
            <div class="mt-4 flex w-1/2 justify-start">
                <x-primary-button type="submit">Save</x-primary-button>
            </div>
        </div>
    </form>
</div>
