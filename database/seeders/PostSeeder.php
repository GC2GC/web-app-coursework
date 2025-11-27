<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        // popular high engagement post
        $post1 = Post::factory()->popular()->create([
            'user_id' => $users->first()->id,
            'title' => 'Popular Post: Getting Started with Laravel',
            'content' => 'This is a popular post with lots of engagement. Learn the basics of Laravel framework.',
        ]);
        $post1->refreshAnalytics();

        // unpopular post 
        $post2 = Post::factory()->unpopular()->create([
            'user_id' => $users->skip(1)->first()->id,
            'title' => 'Unpopular Post: Advanced Concepts',
            'content' => 'This post has no views, likes, or comments.',
        ]);
        $post2->refreshAnalytics();

        // moderate post
        $post3 = Post::factory()->create([
            'user_id' => $users->random()->id,
            'title' => 'Moderate Post: Best Practices',
            'content' => 'A post with moderate engagement showing typical user interaction.',
        ]);
        $post3->refreshAnalytics();

        // views-only post 
        $post4 = Post::factory()->create([
            'user_id' => $users->random()->id,
            'title' => 'Views Only Post: Database Design',
            'content' => 'This post has views and likes but no comments.',
        ]);
        $post4->refreshAnalytics();

        // comment-heavy post
        $post5 = Post::factory()->create([
            'user_id' => $users->random()->id,
            'title' => 'Comment Heavy Post: Discussion Thread',
            'content' => 'This post encourages discussion with many comments.',
        ]);
        $post5->refreshAnalytics();

        // some more random posts
        Post::factory(5)->create([
            'user_id' => $users->random()->id,
        ])->each(function ($post) {
            $post->refreshAnalytics();
        });
    }
}
