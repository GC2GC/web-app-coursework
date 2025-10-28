<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostLike;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostLikeSeeder extends Seeder
{
    /**
     * Seed the post_likes table with varied scenarios.
     * Creates likes using factories with different user/post relationships.
     */
    public function run(): void
    {
        $posts = Post::all();
        $users = User::all();

        foreach ($posts as $post) {
            // Determine number of likes based on post id (for varied scenarios)
            $likeCount = match($post->id) {
                1 => 7,      // Post 1: 7 likes (popular)
                2 => 0,      // Post 2: 0 likes (unpopular)
                3 => 3,      // Post 3: 3 likes (moderate)
                4 => 4,      // Post 4: 4 likes (views-only)
                5 => 3,      // Post 5: 3 likes (comment-heavy)
                default => rand(0, 5),  // Posts 6-10: random 0-5 likes
            };

            // Create likes using factory
            // Ensure different users like each post (one-per-user constraint)
            $likerIds = $users->take($likeCount)->pluck('id');

            foreach ($likerIds as $userId) {
                PostLike::factory()->create([
                    'post_id' => $post->id,
                    'user_id' => $userId,
                ]);
            }
        }

        // Refresh all post like counts
        Post::all()->each(fn($post) => $post->update([
            'likes_count' => $post->likes()->count(),
        ]));
    }
}
