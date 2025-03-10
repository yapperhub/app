<?php

namespace App\Livewire\Forms;

use App\Http\DataVault\PostVault;
use App\Models\Post;
use App\Models\PostDetail;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Form;
use Throwable;

class PostForm extends Form
{
    public string $title = '';

    public string $excerpt = '';

    public $image;

    public string $canonical_url = '';

    public string $content = '';

    public array $tags = [];

    public $published_at = null;

    public function publish(PostDetail $postDetails): void
    {
        $postDetails->update(['published_at' => $this->published_at]);
    }

    /**
     * @throws ValidationException
     * @throws Exception
     * @throws Throwable
     */
    public function update(Post $post, PostDetail $postDetail): Post
    {
        $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'sometimes', 'image', 'max:3072'],
            'canonical_url' => ['nullable', 'url', Rule::unique('posts', 'canonical_url')->ignore($post->id)],
            'content' => ['required', 'string'],
            'tags' => ['nullable', 'array'],
            'published_at' => ['nullable', 'date'],
        ]);

        DB::beginTransaction();

        $postVault = new PostVault;

        try {
            $yapperHubPlatform = $postVault->getPlatform(request()->route('platform'));
            $slug = Str::slug($this->title);

            $post->update([
                'title' => $this->title,
                'canonical_url' => empty($this->canonical_url) ? $postVault->createPostUrl($slug) : $this->canonical_url,
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
                $post->tags()->sync($postVault->tagNameToId(tags: $this->tags));
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
     * @throws Throwable
     */
    public function store(): Post
    {
        $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'sometimes', 'image', 'max:3072'],
            'canonical_url' => ['nullable', 'url', Rule::unique('posts', 'canonical_url')],
            'content' => ['required', 'string'],
            'tags' => ['nullable', 'array'],
            'published_at' => ['nullable', 'date'],
        ]);

        DB::beginTransaction();

        $postVault = new PostVault;

        try {
            $yapperHubPlatform = $postVault->getPlatform();
            $slug = Str::slug($this->title);

            $post = $postVault->createPost(
                title: $this->title,
                slug: $slug,
                canonicalUrl: empty($this->canonical_url) ? $postVault->createPostUrl($slug) : $this->canonical_url,
                userId: auth()->id()
            );

            $postVault->createPostDetails(
                postId: $post->id,
                content: $this->content,
                platformId: $yapperHubPlatform->id,
                excerpt: $this->excerpt,
                featuredImage: $this->image ? $this->image->store('images/posts', 'public') : null
            );

            if (! empty($this->tags)) {
                $post->tags()->sync($postVault->tagNameToId(tags: $this->tags));
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
