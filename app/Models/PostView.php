<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostView extends Model
{
    /** @use HasFactory<\Database\Factories\PostViewFactory> */
    use HasFactory;

    protected $table = 'post_views';

    protected $fillable = [
        'post_id',
        'ip_address',
        'user_id',
        'viewed_date',
    ];

    protected function casts(): array
    {
        return [
            'viewed_date' => 'date',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the post this view is for.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Get the user who viewed the post (if authenticated).
     */
    public function viewer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
