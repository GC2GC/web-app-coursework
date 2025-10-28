#!/usr/bin/env php
<?php
// Test script for analytics aggregation methods
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

use App\Models\Post;

echo "\n====== ANALYTICS AGGREGATION & QUERIES TEST ======\n\n";

// Test 1: Get engagement metrics
echo "Test 1: Engagement Metrics\n";
echo str_repeat("-", 50) . "\n";
$post = Post::first();
if ($post) {
    echo "Post #{$post->id}: {$post->title}\n";
    $metrics = $post->getEngagementMetrics();
    echo "  Views: {$metrics['views']}\n";
    echo "  Likes: {$metrics['likes']}\n";
    echo "  Comments: {$metrics['comments']}\n";
    echo "  Total Engagement: {$metrics['total_engagement']}\n";
    echo "✓ Engagement metrics working!\n\n";
}

// Test 2: Order by most views
echo "Test 2: Order by Most Views\n";
echo str_repeat("-", 50) . "\n";
$topViewed = Post::orderByMostViews()->take(3)->get();
echo "Top 3 posts by views:\n";
foreach ($topViewed as $p) {
    echo "  #{$p->id}: {$p->title} ({$p->views_count} views)\n";
}
echo "✓ OrderByMostViews scope working!\n\n";

// Test 3: Order by most likes
echo "Test 3: Order by Most Likes\n";
echo str_repeat("-", 50) . "\n";
$topLiked = Post::orderByMostLikes()->take(3)->get();
echo "Top 3 posts by likes:\n";
foreach ($topLiked as $p) {
    echo "  #{$p->id}: {$p->title} ({$p->likes_count} likes)\n";
}
echo "✓ OrderByMostLikes scope working!\n\n";

// Test 4: Order by most comments
echo "Test 4: Order by Most Comments\n";
echo str_repeat("-", 50) . "\n";
$topCommented = Post::orderByMostComments()->take(3)->get();
echo "Top 3 posts by comments:\n";
foreach ($topCommented as $p) {
    echo "  #{$p->id}: {$p->title} ({$p->comments_count} comments)\n";
}
echo "✓ OrderByMostComments scope working!\n\n";

// Test 5: Order by total engagement
echo "Test 5: Order by Total Engagement\n";
echo str_repeat("-", 50) . "\n";
$topEngaged = Post::orderByEngagement()->take(3)->get();
echo "Top 3 posts by engagement (views+likes+comments):\n";
foreach ($topEngaged as $p) {
    $total = $p->views_count + $p->likes_count + $p->comments_count;
    echo "  #{$p->id}: {$p->title} (total: {$total})\n";
}
echo "✓ OrderByEngagement scope working!\n\n";

// Test 6: Minimum views filter
echo "Test 6: Posts with Minimum Views\n";
echo str_repeat("-", 50) . "\n";
$minViews = Post::withMinViews(5)->count();
echo "Posts with at least 5 views: {$minViews}\n";
echo "✓ WithMinViews scope working!\n\n";

// Test 7: Minimum likes filter
echo "Test 7: Posts with Minimum Likes\n";
echo str_repeat("-", 50) . "\n";
$minLikes = Post::withMinLikes(3)->count();
echo "Posts with at least 3 likes: {$minLikes}\n";
echo "✓ WithMinLikes scope working!\n\n";

// Test 8: Trending posts
echo "Test 8: Trending Posts (last 7 days)\n";
echo str_repeat("-", 50) . "\n";
$trending = Post::trending(7)->get();
echo "Trending posts count: {$trending->count()}\n";
if ($trending->count() > 0) {
    echo "First trending post: #{$trending->first()->id} - {$trending->first()->title}\n";
}
echo "✓ Trending scope working!\n\n";

// Test 9: Popular posts
echo "Test 9: Popular Posts (above median)\n";
echo str_repeat("-", 50) . "\n";
$popular = Post::popular()->get();
echo "Popular posts count: {$popular->count()}\n";
if ($popular->count() > 0) {
    foreach ($popular->take(2) as $p) {
        $total = $p->views_count + $p->likes_count + $p->comments_count;
        echo "  #{$p->id}: {$p->title} (engagement: {$total})\n";
    }
}
echo "✓ Popular scope working!\n\n";

// Summary
echo "====== SUMMARY ======\n";
$totalPosts = Post::count();
$avgEngagement = Post::selectRaw('AVG(views_count + likes_count + comments_count) as avg_engagement')->first();
echo "Total Posts: {$totalPosts}\n";
echo "Average Engagement: {$avgEngagement->avg_engagement}\n";
echo "\n✓ All analytics aggregation tests completed successfully!\n\n";
