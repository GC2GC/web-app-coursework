<?php
require 'bootstrap/app.php';

use App\Models\Post;
use Illuminate\Support\Facades\DB;

// Boot the application
$app = require_once 'bootstrap/app.php';
$app->boot();

// Test aggregation methods
$posts = Post::withCount('comments', 'likes')->take(3)->get();

echo "\n=== Analytics Aggregation & Query Test ===\n\n";

foreach ($posts as $post) {
    echo "Post #{$post->id}: {$post->title}\n";
    echo "  Views (cached): {$post->views_count}\n";
    echo "  Likes (cached): {$post->likes_count}\n";
    echo "  Comments (cached): {$post->comments_count}\n";
    
    $metrics = $post->getEngagementMetrics();
    echo "  Engagement Metrics:\n";
    echo "    - Views: {$metrics['views']}\n";
    echo "    - Likes: {$metrics['likes']}\n";
    echo "    - Comments: {$metrics['comments']}\n";
    echo "    - Total: {$metrics['total_engagement']}\n";
    echo "\n";
}

// Test scopes
echo "=== Query Scopes Test ===\n\n";

$trending = Post::trending(7)->take(3)->get();
echo "Top 3 Trending Posts (last 7 days):\n";
foreach ($trending as $post) {
    echo "  #{$post->id}: {$post->title} (engagement: " . ($post->views_count + $post->likes_count + $post->comments_count) . ")\n";
}

$most_liked = Post::orderByMostLikes()->take(3)->get();
echo "\nTop 3 Most Liked Posts:\n";
foreach ($most_liked as $post) {
    echo "  #{$post->id}: {$post->title} ({$post->likes_count} likes)\n";
}

echo "\n✓ Analytics aggregation test completed successfully!\n";
