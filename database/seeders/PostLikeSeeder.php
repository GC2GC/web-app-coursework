<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostLike;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostLikeSeeder extends Seeder
{
    public function run(): void
    {
        $posts = Post::all();
        $users = User::all();

        foreach ($posts as $post) {
            // determine number of likes based on post id
            $likeCount = match($post->id) {
                1 => 7,    
                2 => 0,     
                3 => 3,      
                4 => 4,      
                5 => 3,     
                default => rand(0, 5),
            };

            // create likes using factory
            // ensure different users like each post 
            $likerIds = $users->take($likeCount)->pluck('id');

            foreach ($likerIds as $userId) {
                PostLike::factory()->create([
                    'post_id' => $post->id,
                    'user_id' => $userId,
                ]);
            }
        }

        //refresh all post like counts
        Post::all()->each(fn($post) => $post->update([
            'likes_count' => $post->likes()->count(),
        ]));
    }
}
