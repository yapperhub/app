<?php

namespace App\Http\Controllers\Api\V1;

use App\Concerns\Constants;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostContentResource;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * List posts.
     */
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'per_page' => ['integer', 'nullable', 'min:1', 'max:50'],
            'page' => ['integer', 'nullable', 'min:1'],
            'status' => ['string', 'nullable', 'in:draft,published'],
            'query' => ['string', 'nullable'],
        ]);

        $perPage = request('per_page', Constants::PER_PAGE);
        $page = request('page', 1);
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

        $post = $posts->paginate($perPage, ['*'], 'page', $page);

        return response()->json(PostResource::collection($post));
    }

    /**
     * Show post.
     */
    public function show(Post $post): JsonResponse
    {
        $post->load('content', 'tags');

        return response()->json(new PostContentResource($post));
    }
}
