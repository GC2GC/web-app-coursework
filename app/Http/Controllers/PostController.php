<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * get all posts with pagination
     */
    public function index()
    {
        $posts = Post::with('author')
            ->latest()
            ->paginate(15);

        return response()->json([
            'data' => $posts->items(),
            'meta' => [
                'total' => $posts->total(),
                'per_page' => $posts->perPage(),
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
            ],
        ]);
    }

    /**
     * Get a single post with related data.
     * Automatically records a view for the post.
     */
    public function show(Post $post)
    {
        // Record a view for this post
        AnalyticsService::recordView($post);

        $post->load(['author', 'comments.author', 'likes', 'views']);

        return response()->json([
            'data' => [
                'id' => $post->id,
                'title' => $post->title,
                'content' => $post->content,
                'author' => [
                    'id' => $post->author->id,
                    'name' => $post->author->first_name . ' ' . $post->author->last_name,
                    'is_admin' => $post->author->is_administrator,
                ],
                'views_count' => $post->views_count,
                'likes_count' => $post->likes_count,
                'comments_count' => $post->comments_count,
                'created_at' => $post->created_at,
                'updated_at' => $post->updated_at,
            ],
        ]);
    }

    /**
     * Create a new post.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post = Post::create($validated);

        return response()->json([
            'message' => 'Post created successfully',
            'data' => $post,
        ], 201);
    }

    /**
     * Update a post.
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
        ]);

        $post->update($validated);

        return response()->json([
            'message' => 'Post updated successfully',
            'data' => $post,
        ]);
    }

    /**
     * Delete a post.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json([
            'message' => 'Post deleted successfully',
        ]);
    }
}
