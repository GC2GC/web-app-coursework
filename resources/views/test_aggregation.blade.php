<?php
// Testing script - place in routes for testing
use App\Models\Post;

// Test 1: Get all posts with engagement metrics
echo "=== TEST 1: All Posts with Engagement ===\n\n";
$posts = Post::all();
foreach ($posts as $post) {
    $metrics = $post->getEngagementMetrics();
    echo "Post #{$post->id}: {$post->title}\n";
    echo "  Views: {$metrics['views']}, Likes: {$metrics['likes']}, Comments: {$metrics['comments']}\n";
    echo "  Total Engagement: {$metrics['total_engagement']}\n\n";
}

// Test 2: Most viewed posts
echo "\n=== TEST 2: Most Viewed Posts ===\n\n";
Post::orderByMostViews()->take(5)->each(fn($p) => 
    echo "#{$p->id}: {$p->title} - {$p->views_count} views\n"
);

// Test 3: Most liked posts
echo "\n=== TEST 3: Most Liked Posts ===\n\n";
Post::orderByMostLikes()->take(5)->each(fn($p) => 
    echo "#{$p->id}: {$p->title} - {$p->likes_count} likes\n"
);

// Test 4: Posts with minimum views
echo "\n=== TEST 4: Posts with 5+ views ===\n\n";
echo "Count: " . Post::withMinViews(5)->count() . "\n";

// Test 5: Trending posts
echo "\n=== TEST 5: Trending Posts (7 days) ===\n\n";
echo "Count: " . Post::trending(7)->count() . "\n";

// Test 6: Popular posts
echo "\n=== TEST 6: Popular Posts (above median) ===\n\n";
echo "Count: " . Post::popular()->count() . "\n";
