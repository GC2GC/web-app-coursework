<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostView;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PostViewSeeder extends Seeder
{
    /**
     * Seed the post_views table with varied scenarios.
     * Creates unique views (by IP/date) and anonymous views using factories.
     */
    public function run(): void
    {
        $posts = Post::all();
        $users = User::all();

        foreach ($posts as $post) {
            // Determine number of views based on post id (for varied scenarios)
            $viewCount = match($post->id) {
                1 => 15,     // Post 1: 15 views (popular)
                2 => 0,      // Post 2: 0 views (unpopular)
                3 => 8,      // Post 3: 8 views (moderate)
                4 => 8,      // Post 4: 8 views (views-only)
                5 => 5,      // Post 5: 5 views (comment-heavy)
                default => rand(0, 10),  // Posts 6-10: random 0-10 views
            };

            // Create views using factory
            // Mix of authenticated and anonymous views
            $authViews = (int)($viewCount * 0.6);
            $anonViews = $viewCount - $authViews;

            // Authenticated user views - create with random users
            for ($i = 0; $i < $authViews; $i++) {
                PostView::factory()->create([
                    'post_id' => $post->id,
                    'user_id' => $users->random()->id,
                    'ip_address' => '192.168.' . rand(0, 255) . '.' . rand(1, 255),
                    'viewed_date' => Carbon::now()->toDateString(),
                ]);
            }

            // Anonymous (IP-only) views
            for ($i = 0; $i < $anonViews; $i++) {
                PostView::factory()->anonymous()->create([
                    'post_id' => $post->id,
                    'ip_address' => '10.0.' . rand(0, 255) . '.' . rand(1, 255),
                    'viewed_date' => Carbon::now()->toDateString(),
                ]);
            }
        }

        // Refresh all post view counts
        Post::all()->each(fn($post) => $post->update([
            'views_count' => $post->views()->distinct('ip_address')->count('ip_address'),
        ]));
    }
}
