<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;

class PostLikeController extends Controller
{
    /**
     * Toggle a like on a post.
     * POST /api/posts/{post}/like
     */
    public function toggle(Request $request, Post $post)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
        ]);

        $userId = $validated['user_id'];

        // Check if user already liked this post
        $wasLiked = AnalyticsService::hasLiked($post, $userId);

        // Toggle the like
        $isNowLiked = AnalyticsService::toggleLike($post, $userId);

        return response()->json([
            'message' => $isNowLiked ? 'Post liked successfully' : 'Like removed successfully',
            'data' => [
                'post_id' => $post->id,
                'user_id' => $userId,
                'liked' => $isNowLiked,
                'current_likes' => $post->fresh()->likes_count,
            ],
        ], $isNowLiked ? 201 : 200);
    }

    /**
     * Get all likes for a post.
     * GET /api/posts/{post}/likes
     */
    public function index(Post $post)
    {
        $likes = $post->likes()
            ->with('user')
            ->latest()
            ->paginate(50);

        return response()->json([
            'data' => $likes->items(),
            'meta' => [
                'total' => $likes->total(),
                'per_page' => $likes->perPage(),
                'current_page' => $likes->currentPage(),
                'last_page' => $likes->lastPage(),
            ],
        ]);
    }

    /**
     * Check if a user has liked a post.
     * GET /api/posts/{post}/likes/check
     */
    public function check(Request $request, Post $post)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
        ]);

        $userId = $validated['user_id'];
        $hasLiked = AnalyticsService::hasLiked($post, $userId);

        return response()->json([
            'data' => [
                'post_id' => $post->id,
                'user_id' => $userId,
                'liked' => $hasLiked,
            ],
        ]);
    }
}
