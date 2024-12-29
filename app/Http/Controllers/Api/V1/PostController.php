<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * List all posts.
     */
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'per_page' => ['integer', 'nullable', 'min:1', 'max:50'],
            'page' => ['integer', 'nullable', 'min:1'],
            'status' => ['string', 'nullable', 'in:draft,published'],
        ]);

        $perPage = request('per_page', 20);
        $page = request('page', 1);
        $status = request('status');

        $posts = Post::query()->where('user_id', auth()->id())->with('content');

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

        return response()->json([
            'message' => 'List of all posts',
            'payload' => $posts->paginate($perPage, ['*'], 'page', $page),
        ]);
    }

    /**
     * Show a post.
     */
    public function show(Post $post): JsonResponse
    {
        return response()->json([
            'message' => 'Hello World',
        ]);
    }
}
