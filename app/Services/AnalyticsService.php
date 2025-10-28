<?php

namespace App\Services;

use App\Models\Post;
use App\Models\PostLike;
use App\Models\PostView;
use Illuminate\Support\Carbon;

class AnalyticsService
{
    /**
     * Record a view for a post.
     * Ensures one view per IP/user per day.
     */
    public static function recordView(Post $post, ?string $ipAddress = null, ?int $userId = null): bool
    {
        $today = Carbon::now()->toDateString();
        
        // If neither IP nor user is provided, use request IP
        if (!$ipAddress && !$userId) {
            $ipAddress = request()->ip();
        }

        // Check if view already exists for today
        $existingView = PostView::where('post_id', $post->id)
            ->where('viewed_date', $today);

        if ($ipAddress) {
            $existingView->where('ip_address', $ipAddress);
        }

        if ($userId) {
            $existingView->where('user_id', $userId);
        }

        // If view exists for this IP/user today, don't create duplicate
        if ($existingView->exists()) {
            return false;
        }

        // Create new view record
        PostView::create([
            'post_id' => $post->id,
            'ip_address' => $ipAddress,
            'user_id' => $userId,
            'viewed_date' => $today,
        ]);

        // Update post views count
        $post->update([
            'views_count' => $post->views()->distinct('ip_address')->count('ip_address'),
        ]);

        return true;
    }

    /**
     * Toggle a like on a post by a user.
     * Returns true if like was created, false if removed.
     */
    public static function toggleLike(Post $post, int $userId): bool
    {
        $like = PostLike::where('post_id', $post->id)
            ->where('user_id', $userId)
            ->first();

        if ($like) {
            // Remove like
            $like->delete();
            $liked = false;
        } else {
            // Add like
            PostLike::create([
                'post_id' => $post->id,
                'user_id' => $userId,
            ]);
            $liked = true;
        }

        // Update post likes count
        $post->update([
            'likes_count' => $post->likes()->count(),
        ]);

        return $liked;
    }

    /**
     * Check if a user has liked a post.
     */
    public static function hasLiked(Post $post, int $userId): bool
    {
        return PostLike::where('post_id', $post->id)
            ->where('user_id', $userId)
            ->exists();
    }

    /**
     * Get like count for a post.
     */
    public static function getLikeCount(Post $post): int
    {
        return $post->likes()->count();
    }

    /**
     * Get unique view count for a post.
     */
    public static function getViewCount(Post $post): int
    {
        return $post->views()->distinct('ip_address')->count('ip_address');
    }
}
