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
        'image_path',
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

    // relationship to user who created the post
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // get all comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function views()
    {
        return $this->hasMany(PostView::class);
    }

    // all likes on this post
    public function likes()
    {
        return $this->hasMany(PostLike::class);
    }

    public function getEngagementMetrics(): array
    {
        return [
            'views' => $this->views_count,
            'likes' => $this->likes_count,
            'comments' => $this->comments_count,
            'total_engagement' => $this->views_count + $this->likes_count + $this->comments_count,
        ];
    }

      public function refreshAnalytics()
    {
        $this->update([
            'views_count' => $this->views()->distinct('ip_address')->count('ip_address'),
            'likes_count' => $this->likes()->count(),
            'comments_count' => $this->comments()->count(),
        ]);


        return $this;
    }


    // order by most popular first
    public function scopeOrderByMostViews($query)
    {
        return $query->orderBy('views_count', 'desc');
    }

    //most likes
    public function scopeOrderByMostLikes($query)
    {
        return $query->orderBy('likes_count', 'desc');
    }

    //most comments
    public function scopeOrderByMostComments($query)
    {
        return $query->orderBy('comments_count', 'desc');
    }

    //overall engagement
    public function scopeOrderByEngagement($query)
    {
        return $query->orderByRaw('(views_count + likes_count + comments_count) desc');
    }


    //trending
    public function scopeTrending($query, int $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days))
            ->orderByEngagement();
    }

    //popular
    public function scopePopular($query)
    {
        //median engagement calculation
        $medianEngagement = self::selectRaw('(views_count + likes_count + comments_count) as total_engagement')
            ->get()
            ->median('total_engagement');

        return $query->whereRaw('(views_count + likes_count + comments_count) >= ?', [$medianEngagement])
            ->orderByEngagement();
    }

    //posts with minimum views
    public function scopeWithMinViews($query, int $minViews)
    {
        return $query->where('views_count', '>=', $minViews);
    }

    //posts with minimum likes
    public function scopeWithMinLikes($query, int $minLikes)
    {
        return $query->where('likes_count', '>=', $minLikes);
    }
}
