<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\PostLikeController;
use Illuminate\Support\Facades\Route;

// Posts endpoints
Route::prefix('posts')->group(function () {
    Route::get('/', [PostController::class, 'index']);
    Route::post('/', [PostController::class, 'store']);
    Route::get('{post}', [PostController::class, 'show']);
    Route::put('{post}', [PostController::class, 'update']);
    Route::delete('{post}', [PostController::class, 'destroy']);

    // Analytics endpoints
    Route::get('{post}/analytics', [AnalyticsController::class, 'getAnalytics']);
    Route::post('{post}/view', [AnalyticsController::class, 'recordView']);

    // Likes endpoints
    Route::post('{post}/like', [PostLikeController::class, 'toggle']);
    Route::get('{post}/likes', [PostLikeController::class, 'index']);
    Route::get('{post}/likes/check', [PostLikeController::class, 'check']);

    // Comments nested under posts
    Route::prefix('{post}/comments')->group(function () {
        Route::get('/', [CommentController::class, 'index']);
        Route::post('/', [CommentController::class, 'store']);
        Route::get('{comment}', [CommentController::class, 'show']);
        Route::put('{comment}', [CommentController::class, 'update']);
        Route::delete('{comment}', [CommentController::class, 'destroy']);
    });
});

// Analytics endpoints
Route::prefix('analytics')->group(function () {
    Route::get('posts', [AnalyticsController::class, 'getAllAnalytics']);
});

// Test aggregation endpoints
Route::prefix('test')->group(function () {
    Route::get('aggregation', function () {
        return response()->json([
            'all_posts' => \App\Models\Post::all()->map(fn($p) => [
                'id' => $p->id,
                'title' => $p->title,
                'metrics' => $p->getEngagementMetrics(),
            ]),
            'most_viewed' => \App\Models\Post::orderByMostViews()->take(3)->get()->map(fn($p) => [
                'id' => $p->id,
                'title' => $p->title,
                'views' => $p->views_count,
            ]),
            'most_liked' => \App\Models\Post::orderByMostLikes()->take(3)->get()->map(fn($p) => [
                'id' => $p->id,
                'title' => $p->title,
                'likes' => $p->likes_count,
            ]),
            'most_commented' => \App\Models\Post::orderByMostComments()->take(3)->get()->map(fn($p) => [
                'id' => $p->id,
                'title' => $p->title,
                'comments' => $p->comments_count,
            ]),
            'most_engaged' => \App\Models\Post::orderByEngagement()->take(3)->get()->map(fn($p) => [
                'id' => $p->id,
                'title' => $p->title,
                'engagement' => $p->views_count + $p->likes_count + $p->comments_count,
            ]),
            'posts_with_5_plus_views' => \App\Models\Post::withMinViews(5)->count(),
            'posts_with_3_plus_likes' => \App\Models\Post::withMinLikes(3)->count(),
            'trending_count' => \App\Models\Post::trending(7)->count(),
            'popular_count' => \App\Models\Post::popular()->count(),
        ]);
    });
});

