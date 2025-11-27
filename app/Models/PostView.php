<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class PostView extends Model
{
    /** @use HasFactory<\Database\Factories\PostViewFactory> */
    use HasFactory;


    protected $table = 'post_views';

    //fillable fields
    protected $fillable = [
        'post_id',
        'ip_address',
        'user_id',
        'viewed_date',
    ];

    //casting to datetime
    protected function casts(): array
    {
        return [
            'viewed_date' => 'date',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * post this view is for
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * get the user who viewed the post
     */
    public function viewer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
