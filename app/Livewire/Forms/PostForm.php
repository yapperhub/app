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

    #[Validate('nullable|sometimes|image|max:3072')] // 3MB
    public $image;

    #[Validate('nullable|url')]
    public string $canonical_url = '';

    #[Validate('required|string')]
    public string $content = '';

    /**
     * @throws ValidationException
     * @throws Exception
     */
    public function update(Post $post, PostDetail $postDetail): Post
    {
        $this->validate();

        DB::beginTransaction();

        try {
            $yapperHubPlatform = $this->getPlatform(request()->route('platform'));
            $slug = Str::slug($this->title);

            $post->update([
                'title' => $this->title,
                'canonical_url' => empty($this->canonical_url) ? $this->createPostUrl($slug) : $this->canonical_url,
                'slug' => $slug,
            ]);

            if ($this->image) {
                $featuredImageUrl = $this->image->store('images/posts', 'public');
                $postDetail->update(['featured_image' => $featuredImageUrl]);
            }

            $postDetail->update([
                'excerpt' => $this->excerpt,
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

            $featuredImageUrl = null;
            if ($this->image) {
                $featuredImageUrl = $this->image->store('images/posts', 'public');
            }

            PostDetail::query()->create([
                'post_id' => $post->id,
                'excerpt' => $this->excerpt,
                'featured_image' => $featuredImageUrl,
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
}
