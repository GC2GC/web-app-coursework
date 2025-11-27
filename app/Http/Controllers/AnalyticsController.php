<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    /**
     * record the view of a post on request
     */
    public function recordView(Request $request, Post $post)
    {
        $validated = $request->validate([
            'ip_address' => 'sometimes|ip',
            'user_id' => 'sometimes|integer|exists:users,id',
        ]);

        $ipAddress = $validated['ip_address'] ?? null;
        $userId = $validated['user_id'] ?? null;

        $recorded = AnalyticsService::recordView($post, $ipAddress, $userId);

        return response()->json([
            'message' => $recorded ? 'View recorded successfully' : 'View already recorded for today',
            'data' => [
                'post_id' => $post->id,
                'recorded' => $recorded,
                'current_views' => $post->fresh()->views_count,
            ],
        ]);
    }

    /**
     * get analytics for a specific post
     */
    public function getAnalytics(Post $post)
    {
        $post->refresh();

        return response()->json([
            'data' => [
                'post_id' => $post->id,
                'title' => $post->title,
                'views_count' => AnalyticsService::getViewCount($post),
                'likes_count' => AnalyticsService::getLikeCount($post),
                'comments_count' => $post->comments()->count(),
                'unique_viewers' => $post->views()->select('ip_address')->distinct()->count(),
                'liking_users' => $post->likes()->count(),
                'commenting_users' => $post->comments()->select('user_id')->distinct()->count(),
            ],
        ]);
    }



    /**
     * all post analytics
     */
    public function getAllAnalytics()
    {
        $posts = Post::all()->map(function ($post) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'views_count' => AnalyticsService::getViewCount($post),
                'likes_count' => AnalyticsService::getLikeCount($post),
                'comments_count' => $post->comments()->count(),
            ];
        });

        
        return response()->json([
            'data' => $posts,
            'total_posts' => count($posts),
        ]);
    }
}
