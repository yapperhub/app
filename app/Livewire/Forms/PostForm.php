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

    public bool $isPublished = false;

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
            $slug = Str::slug($this->title);

            $post = Post::query()->create([
                'title' => $this->title,
                'canonical_url' => empty($this->canonical_url) ? $this->createPostUrl($slug) : $this->canonical_url,
                'slug' => $slug,
                'user_id' => auth()->id(),
            ]);

            PostDetail::query()->create([
                'post_id' => $post->id,
                'excerpt' => $this->excerpt,
                'featured_image' => $this->featured_image,
                'content' => $this->content,
                'platform_id' => $yapperHubPlatform->id,
                'published_at' => $this->isPublished ? now() : null,
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

    public function setPublished(): void
    {
        $this->isPublished = true;
    }

    /**
     * @throws ValidationException
     */
    public function update(): void
    {
        $this->validate();

        // Update the post...
    }
}
