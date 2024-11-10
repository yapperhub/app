<?php

namespace App\Livewire\Forms;

use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Form;

class PostForm extends Form
{
    #[Validate('required|string|max:255')]
    public string $title = '';

    #[Validate('required|string|max:255')]
    public string $excerpt = '';

    #[Validate('nullable|url')]
    public string $featured_image = '';

    #[Validate('required|string')]
    public string $content = '';

    /**
     * @throws ValidationException
     */
    public function store()
    {
        $this->validate();

        // Store the post...
    }

    /**
     * @throws ValidationException
     */
    public function update()
    {
        $this->validate();

        // Update the post...
    }
}
