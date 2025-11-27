<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    
    /**
     * model state
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence(6),
            'content' => fake()->paragraphs(3, true),
            'views_count' => 0,
            'likes_count' => 0,
            'comments_count' => 0,
        ];
    }


    /**
     * high engagement post
     */
    public function popular(): static
    {
        return $this->state(fn (array $attributes) => [
            'views_count' => fake()->numberBetween(100, 500),
            'likes_count' => fake()->numberBetween(50, 200),
            'comments_count' => fake()->numberBetween(20, 100),
        ]);
    }



    /**
     * low engagement post
     */
    public function unpopular(): static
    {
        return $this->state(fn (array $attributes) => [
            'views_count' => 0,
            'likes_count' => 0,
            'comments_count' => 0,
        ]);
    }
}
