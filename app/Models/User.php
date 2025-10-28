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
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'is_administrator',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
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
     * Get posts authored by this user.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get comments written by this user.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get likes given by this user.
     */
    public function likes()
    {
        return $this->hasMany(PostLike::class);
    }

    /**
     * Get views recorded for this user.
     */
    public function views()
    {
        return $this->hasMany(PostView::class);
    }
}
