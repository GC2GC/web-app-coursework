<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PostLike>
 */
class PostLikeFactory extends Factory
{
    /**
     * model state
     */
    public function definition(): array
    {
        return [
            'post_id' => Post::factory(),
            'user_id' => User::factory(),
        ];
    }

    /**
     * create a like from a user
     */
    public function byUserForPost(User $user, Post $post): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
    }
}
