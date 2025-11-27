<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PostView>
 */
class PostViewFactory extends Factory
{
    /**
     * state
     */
    public function definition(): array
    {
        return [
            'post_id' => Post::factory(),
            'ip_address' => fake()->ipv4(),
            'user_id' => fake()->boolean(70) ? User::factory() : null,
            'viewed_date' => fake()->dateTimeBetween('-30 days', 'now'),
        ];
    }

    /**
     *create view
     */
    public function byUser(User $user): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => $user->id,
        ]);
    }

    /**
     * create view for anonymous user
     */
    public function anonymous(): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => null,
        ]);
    }
}
