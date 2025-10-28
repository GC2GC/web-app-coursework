<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'views_count',
        'likes_count',
        'comments_count',
    ];

    protected function casts(): array
    {
        return [
            'views_count' => 'integer',
            'likes_count' => 'integer',
            'comments_count' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the author of this post.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get all comments on this post.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get all views recorded for this post.
     */
    public function views()
    {
        return $this->hasMany(PostView::class);
    }

    /**
     * Get all likes for this post.
     */
    public function likes()
    {
        return $this->hasMany(PostLike::class);
    }

    /**
     * Get unique views count for this post.
     */
    public function getUniqueViewsCountAttribute()
    {
        return $this->views()->distinct('ip_address')->count('ip_address');
    }

    /**
     * Get the count of likes for this post.
     */
    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }

    /**
     * Get the count of comments for this post.
     */
    public function getCommentsCountAttribute()
    {
        return $this->comments()->count();
    }

    /**
     * Refresh all cached analytics counters.
     */
    public function refreshAnalytics()
    {
        $this->update([
            'views_count' => $this->views()->distinct('ip_address')->count('ip_address'),
            'likes_count' => $this->likes()->count(),
            'comments_count' => $this->comments()->count(),
        ]);

        return $this;
    }

    /**
     * Get unique views count (calculated from views table).
     */
    public function getUniqueViewsAttribute(): int
    {
        return $this->views()->distinct('ip_address')->count('ip_address');
    }

    /**
     * Get current likes count (calculated from likes table).
     */
    public function getCurrentLikesAttribute(): int
    {
        return $this->likes()->count();
    }

    /**
     * Get current comments count (calculated from comments table).
     */
    public function getCurrentCommentsAttribute(): int
    {
        return $this->comments()->count();
    }

    /**
     * Get engagement metrics for this post.
     * Returns an array with views, likes, and comments counts.
     */
    public function getEngagementMetrics(): array
    {
        return [
            'views' => $this->views_count,
            'likes' => $this->likes_count,
            'comments' => $this->comments_count,
            'total_engagement' => $this->views_count + $this->likes_count + $this->comments_count,
        ];
    }

    /**
     * Scope: Order posts by most views.
     */
    public function scopeOrderByMostViews($query)
    {
        return $query->orderBy('views_count', 'desc');
    }

    /**
     * Scope: Order posts by most likes.
     */
    public function scopeOrderByMostLikes($query)
    {
        return $query->orderBy('likes_count', 'desc');
    }

    /**
     * Scope: Order posts by most comments.
     */
    public function scopeOrderByMostComments($query)
    {
        return $query->orderBy('comments_count', 'desc');
    }

    /**
     * Scope: Order posts by total engagement (views + likes + comments).
     */
    public function scopeOrderByEngagement($query)
    {
        return $query->orderByRaw('(views_count + likes_count + comments_count) desc');
    }

    /**
     * Scope: Filter posts with minimum views.
     */
    public function scopeWithMinViews($query, int $minViews)
    {
        return $query->where('views_count', '>=', $minViews);
    }

    /**
     * Scope: Filter posts with minimum likes.
     */
    public function scopeWithMinLikes($query, int $minLikes)
    {
        return $query->where('likes_count', '>=', $minLikes);
    }

    /**
     * Scope: Filter posts with minimum comments.
     */
    public function scopeWithMinComments($query, int $minComments)
    {
        return $query->where('comments_count', '>=', $minComments);
    }

    /**
     * Scope: Get trending posts (high engagement in last N days).
     */
    public function scopeTrending($query, int $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days))
            ->orderByEngagement();
    }

    /**
     * Scope: Get popular posts (above median engagement).
     */
    public function scopePopular($query)
    {
        $medianEngagement = self::selectRaw('(views_count + likes_count + comments_count) as total_engagement')
            ->get()
            ->median('total_engagement');

        return $query->whereRaw('(views_count + likes_count + comments_count) >= ?', [$medianEngagement])
            ->orderByEngagement();
    }
}
