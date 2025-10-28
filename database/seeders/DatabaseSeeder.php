<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     * Orchestrates all seeders in proper order.
     */
    public function run(): void
    {
        // Seed in order: Users → Posts → Comments → Views → Likes
        $this->call([
            UserSeeder::class,
            PostSeeder::class,
            CommentSeeder::class,
            PostViewSeeder::class,
            PostLikeSeeder::class,
        ]);
    }
}
