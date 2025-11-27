<?php

namespace App\Services;

use App\Models\Post;
use App\Models\PostLike;
use App\Models\PostView;
use App\Models\User;
use App\Notifications\PostLiked;
use Illuminate\Support\Carbon;

class AnalyticsService
{
    /**
     * record a view for a post
     * creates a new view record on every request
     */
    public static function recordView(Post $post, ?string $ipAddress = null, ?int $userId = null): bool
    {
        $today = Carbon::now()->toDateString();
        
        // Use authenticated user if available and not explicitly provided
        if ($userId === null && auth()->check()) {
            $userId = auth()->id();
        }
        
        // if neither IP nor user is provided, use request IP
        if (!$ipAddress) {
            $ipAddress = request()->ip();
        }

        // always create a new view record
        PostView::create([
            'post_id' => $post->id,
            'ip_address' => $ipAddress,
            'user_id' => $userId,
            'viewed_date' => $today,
        ]);

        // update view count
        $post->update([
            'views_count' => $post->views()->count(),
        ]);

        return true;
    }

    /**
     * toggle like
     * Returns true if like was created, false if removed
     */
    public static function toggleLike(Post $post, int $userId): bool
    {
        $like = PostLike::where('post_id', $post->id)
            ->where('user_id', $userId)
            ->first();

        if ($like) {
            $like->delete();
            $liked = false;
            \Log::info("Like removed for user $userId on post {$post->id}");
        } else {
            try {
                PostLike::create([
                    'post_id' => $post->id,
                    'user_id' => $userId,
                ]);
                $liked = true;
                
                // Send notification to post owner if they didn't like their own post
                $post->load('author');
                if ($post->author && $post->author->id !== $userId) {
                    $liker = User::find($userId);
                    if ($liker) {
                        $post->author->notify(new PostLiked($post, $liker));
                    }
                }
            } catch (\Exception $e) {
                // server log the error
                \Log::error("faied to create like for user $userId on post " . $e->getMessage());
            }
        }

        // update like count
        $likeCount = PostLike::where('post_id', $post->id)->count();
        $post->update([
            'likes_count' => $likeCount,
        ]);

        return $liked;
    }

    /**
     * check if user has liked a post
     */
    public static function hasLiked(Post $post, int $userId): bool
    {
        return PostLike::where('post_id', $post->id)
            ->where('user_id', $userId)
            ->exists();
    }

    /**
     * get like count for a post
     */
    public static function getLikeCount(Post $post): int
    {
        return $post->likes()->count();
    }

    /**
     * get view count
     */
    public static function getViewCount(Post $post): int
    {
        return $post->views()->distinct('ip_address')->count('ip_address');
    }
}
