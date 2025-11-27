<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // create admin user
        User::factory()->admin()->create([
            'email' => 'admin@example.com',
            'first_name' => 'Admin',
            'last_name' => 'User',
        ]);

        // create regular users
        User::factory()->regular()->create([
            'email' => 'john@example.com',
            'first_name' => 'John',
            'last_name' => 'Doe',
        ]);

        //create 8 random users
        User::factory(8)->regular()->create();
    }
}
