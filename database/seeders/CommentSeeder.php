<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Seed the comments table with varied scenarios.
     * Creates comments using factories with different user/post relationships.
     */
    public function run(): void
    {
        $posts = Post::all();
        $users = User::all();

        foreach ($posts as $post) {
            // Determine number of comments based on post id (for varied scenarios)
            $commentCount = match($post->id) {
                1 => 8,     // Post 1: 8 comments
                2 => 0,      // Post 2: 0 comments (unpopular)
                3 => 3,     // Post 3: 3 comments (moderate)
                4 => 0,      // Post 4: 0 comments (views-only)
                5 => 10,    // Post 5: 10 comments 
                default => rand(0, 5),  // Posts 6-10: random 0-5 comments
            };

            // Create comments using factory
            Comment::factory($commentCount)->create([
                'post_id' => $post->id,
                'user_id' => $users->random()->id,
            ]);
        }

        // Refresh all post comment counts
        Post::all()->each(fn($post) => $post->update([
            'comments_count' => $post->comments()->count(),
        ]));
    }
}
