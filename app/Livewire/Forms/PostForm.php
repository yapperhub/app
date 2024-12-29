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

    #[Validate('nullable|url|unique:posts,canonical_url')]
    public string $canonical_url = '';

    #[Validate('required|string')]
    public string $content = '';

    #[Validate('nullable|array')]
    public array $tags = [];

    #[Validate('nullable|date')]
    public $published_at = null;

    public function publish(PostDetail $postDetails): void
    {
        $postDetails->update(['published_at' => $this->published_at]);
    }

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

            if (! empty($this->tags)) {
                $post->tags()->sync($this->tagNameToId());
            }

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
    public function store(): Post
    {
        $this->validate();

        DB::beginTransaction();

        try {
            $yapperHubPlatform = $this->getPlatform();
            $slug = Str::slug($this->title);

            $post = $this->createPost(
                title: $this->title,
                slug: $slug,
                canonicalUrl: empty($this->canonical_url) ? $this->createPostUrl($slug) : $this->canonical_url,
                userId: auth()->id()
            );

            PostDetail::query()->create([
                'post_id' => $post->id,
                'excerpt' => $this->excerpt,
                'featured_image' => $this->image ? $this->image->store('images/posts', 'public') : null,
                'content' => $this->content,
                'platform_id' => $yapperHubPlatform->id,
            ]);

            if (! empty($this->tags)) {
                $post->tags()->sync($this->tagNameToId());
            }

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

    public function unpublish(PostDetail $postDetails): void
    {
        $postDetails->update(['published_at' => null]);
    }
}
