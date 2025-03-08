<?php

namespace App\Http\Controllers\Api\V1;

use App\Concerns\Constants;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class PostController extends Controller
{
    use \App\Concerns\Post;

    /**
     * List posts.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $request->validate([
            'per_page' => ['integer', 'nullable', 'min:1', 'max:50'],
            'page' => ['integer', 'nullable', 'min:1'],
            'status' => ['string', 'nullable', 'in:draft,published'],
            'query' => ['string', 'nullable'],
        ]);

        $perPage = request('per_page', Constants::PER_PAGE);
        $page = request('page', Constants::DEFAULT_PAGE);
        $status = request('status');
        $query = request('query');

        $posts = Post::query()->where('user_id', auth()->id())->with(['content', 'tags']);

        if ($status === 'draft') {
            $posts->whereHas('content', function ($query): void {
                $query->whereNull('published_at');
            });
        }

        if ($status === 'published') {
            $posts->whereHas('content', function ($query): void {
                $query->whereNotNull('published_at');
                $query->where('published_at', '<=', now());
            });
        }

        if ($query) {
            $posts->where('title', 'like', "%$query%");
        }

        return PostResource::collection($posts->paginate($perPage, ['*'], 'page', $page));
    }

    /**
     * Post Details.
     */
    public function show(Post $post)
    {
        $post->load('content', 'tags');

        return (new PostResource($post))->withContent();
    }

    /**
     * Create post.
     *
     * @throws Exception
     * @throws Throwable
     */
    public function store()
    {
        $data = request()->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'canonical_url' => ['required', 'url', 'unique:posts,canonical_url'],
            'content' => ['required', 'string'],
            'tags' => ['array'],
            'tags.*' => ['string'],
            'featured_image' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        if ($this->postExists(slug: $data['slug'], userId: auth()->id())) {
            return response()->json(['message' => 'Post already exists with same slug'], Response::HTTP_CONFLICT);
        }

        DB::beginTransaction();

        try {
            $post = $this->createPost(
                title: $data['title'],
                slug: $data['slug'],
                canonicalUrl: $data['canonical_url'],
                userId: auth()->id(),
            );

            return response()->json(['message' => 'Post created successfully', 'id' => $post->id], Response::HTTP_CREATED);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        } catch (Throwable $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
}
