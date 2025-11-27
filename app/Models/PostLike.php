<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostLike extends Model
{
    /** @use HasFactory<\Database\Factories\PostLikeFactory> */
    use HasFactory;

    protected $table = 'post_likes';

    //fillable fields
    protected $fillable = [
        'post_id',
        'user_id',
    ];

    //casting to datetime 
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * post this like is for
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * person who liked the post
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
