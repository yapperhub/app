<?php

namespace App\Livewire\Forms;

use App\Models\Post;
use App\Models\PostDetail;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Throwable;

class PostForm extends Form
{
    use \App\Concerns\Post;

    #[Validate('required|string|max:255')]
    public string $title = '';

    #[Validate('required|string|max:255')]
    public string $excerpt = '';

    #[Validate('nullable|url')]
    public string $featured_image = '';

    #[Validate('nullable|url')]
    public string $canonical_url = '';

    #[Validate('required|string')]
    public string $content = '';

    /**
     * @throws ValidationException
     * @throws Exception
     */
    public function store()
    {
        $this->validate();

        DB::beginTransaction();

        try {
            $yapperHubPlatform = $this->getPlatform();

            $post = Post::query()->create([
                'title' => $this->title,
                'canonical_url' => $this->canonical_url,
                'slug' => Str::slug($this->title),
                'user_id' => auth()->id(),
            ]);

            PostDetail::query()->create([
                'post_id' => $post->id,
                'excerpt' => $this->excerpt,
                'featured_image' => $this->featured_image,
                'content' => $this->content,
                'platform_id' => $yapperHubPlatform->id,
            ]);

            DB::commit();

            return $post;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        } catch (Throwable $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
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
