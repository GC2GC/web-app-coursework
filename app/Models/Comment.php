<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /** @use HasFactory<\Database\Factories\CommentFactory> */
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'content',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * get the post that this comment belongs to
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * get comment author
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
