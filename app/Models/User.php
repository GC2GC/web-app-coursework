<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * attributes that are mass assignable
     *
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'is_administrator',
    ];

    /**
     * hidden attributes
     *
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * should be cast
     *
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_administrator' => 'boolean',
        ];
    }

    /**
     * posts authored by this user
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }


    /**
     *comments made by user
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * likes made by user
     */
    public function likes()
    {
        return $this->hasMany(PostLike::class);
    }

    /**
     * views recorder for this user
     */
    public function views()
    {
        return $this->hasMany(PostView::class);
    }
}
