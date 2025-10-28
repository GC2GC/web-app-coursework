<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Seed the posts table with varied engagement scenarios.
     * Creates posts with diverse engagement patterns to cover edge cases.
     */
    public function run(): void
    {
        $users = User::all();

        // Post 1: Popular post (high engagement)
        $post1 = Post::factory()->popular()->create([
            'user_id' => $users->first()->id,
            'title' => 'Popular Post: Getting Started with Laravel',
            'content' => 'This is a popular post with lots of engagement. Learn the basics of Laravel framework.',
        ]);
        $post1->refreshAnalytics();

        // Post 2: Unpopular post (no engagement)
        $post2 = Post::factory()->unpopular()->create([
            'user_id' => $users->skip(1)->first()->id,
            'title' => 'Unpopular Post: Advanced Concepts',
            'content' => 'This post has no views, likes, or comments.',
        ]);
        $post2->refreshAnalytics();

        // Post 3: Moderate post (some engagement)
        $post3 = Post::factory()->create([
            'user_id' => $users->random()->id,
            'title' => 'Moderate Post: Best Practices',
            'content' => 'A post with moderate engagement showing typical user interaction.',
        ]);
        $post3->refreshAnalytics();

        // Post 4: Views-only post (views and likes but no comments)
        $post4 = Post::factory()->create([
            'user_id' => $users->random()->id,
            'title' => 'Views Only Post: Database Design',
            'content' => 'This post has views and likes but no comments.',
        ]);
        $post4->refreshAnalytics();

        // Post 5: Comment-heavy post (many comments, few views/likes)
        $post5 = Post::factory()->create([
            'user_id' => $users->random()->id,
            'title' => 'Comment Heavy Post: Discussion Thread',
            'content' => 'This post encourages discussion with many comments.',
        ]);
        $post5->refreshAnalytics();

        // Posts 6-10: Random posts with varied engagement
        Post::factory(5)->create([
            'user_id' => $users->random()->id,
        ])->each(function ($post) {
            $post->refreshAnalytics();
        });
    }
}
