<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * model state
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'is_administrator' => false,
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * the models email address should be unverified
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * the user in context is an administrator
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_administrator' => true,
        ]);
    }

    /**
     * the user in context is not an admn
     */
    public function regular(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_administrator' => false,
        ]);
    }
}
