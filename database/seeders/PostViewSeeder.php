<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostView;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PostViewSeeder extends Seeder
{
    public function run(): void
    {
        $posts = Post::all();
        $users = User::all();

        foreach ($posts as $post) {
            $viewCount = match($post->id) {
                1 => 15,    
                2 => 0,     
                3 => 8,     
                4 => 8,     
                5 => 5,     
                default => rand(0, 10),  
            };


            // mix of authenticated and anonymous views
            $authViews = (int)($viewCount * 0.6);
            $anonViews = $viewCount - $authViews;

            // authaenticated views
            for ($i = 0; $i < $authViews; $i++) {
                PostView::factory()->create([
                    'post_id' => $post->id,
                    'user_id' => $users->random()->id,
                    'ip_address' => '192.168.' . rand(0, 255) . '.' . rand(1, 255),
                    'viewed_date' => Carbon::now()->toDateString(), // carbon for consistent date
                ]);
            }

            // anonymous views - create without user_id
            for ($i = 0; $i < $anonViews; $i++) {
                PostView::factory()->anonymous()->create([
                    'post_id' => $post->id,
                    'ip_address' => '10.0.' . rand(0, 255) . '.' . rand(1, 255),
                    'viewed_date' => Carbon::now()->toDateString(),
                ]);
            }
        }

        //refresh all post views counts
        Post::all()->each(fn($post) => $post->update([
            'views_count' => $post->views()->distinct('ip_address')->count('ip_address'),
        ]));
    }
}
