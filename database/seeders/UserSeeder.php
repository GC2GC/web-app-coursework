<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed the users table.
     * Creates 1 admin user, 1 regular user, and 8 random users.
     */
    public function run(): void
    {
        // Create admin user (stable, deterministic)
        User::factory()->admin()->create([
            'email' => 'admin@example.com',
            'first_name' => 'Admin',
            'last_name' => 'User',
        ]);

        // Create regular user (stable, deterministic)
        User::factory()->regular()->create([
            'email' => 'john@example.com',
            'first_name' => 'John',
            'last_name' => 'Doe',
        ]);

        // Create 8 random users
        User::factory(8)->regular()->create();
    }
}
