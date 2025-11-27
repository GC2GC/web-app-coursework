<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $posts = Post::all();
        $users = User::all();

        foreach ($posts as $post) {
            // determine number of comments based on post id 
            $commentCount = match($post->id) {
                1 => 8,     
                2 => 0,      
                3 => 3,     
                4 => 0,     
                5 => 10,    
                default => rand(0, 5),  
            };

            // create comments using factory
            Comment::factory($commentCount)->create([
                'post_id' => $post->id,
                'user_id' => $users->random()->id,
            ]);
        }

        // refresh comments_count for all posts
        Post::all()->each(fn($post) => $post->update([
            'comments_count' => $post->comments()->count(),
        ]));
    }
}
