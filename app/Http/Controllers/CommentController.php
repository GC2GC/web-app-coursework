<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Get all comments for a specific post.
     */
    public function index(Post $post)
    {
        $comments = $post->comments()
            ->with('author')
            ->latest()
            ->paginate(20);

        return response()->json([
            'data' => $comments->items(),
            'meta' => [
                'total' => $comments->total(),
                'per_page' => $comments->perPage(),
                'current_page' => $comments->currentPage(),
                'last_page' => $comments->lastPage(),
            ],
        ]);
    }

    /**
     * Get a single comment.
     */
    public function show(Post $post, Comment $comment)
    {
        // Verify comment belongs to post
        if ($comment->post_id !== $post->id) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        $comment->load('author', 'post');

        return response()->json(['data' => $comment]);
    }

    /**
     * Create a comment on a post.
     */
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'content' => 'required|string|min:1|max:5000',
        ]);

        $comment = $post->comments()->create($validated);

        // Increment post comment count
        $post->increment('comments_count');

        return response()->json([
            'message' => 'Comment created successfully',
            'data' => $comment->load('author'),
        ], 201);
    }

    /**
     * Update a comment.
     */
    public function update(Request $request, Post $post, Comment $comment)
    {
        // Verify comment belongs to post
        if ($comment->post_id !== $post->id) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        $validated = $request->validate([
            'content' => 'required|string|min:1|max:5000',
        ]);

        $comment->update($validated);

        return response()->json([
            'message' => 'Comment updated successfully',
            'data' => $comment,
        ]);
    }

    /**
     * Delete a comment.
     */
    public function destroy(Post $post, Comment $comment)
    {
        // Verify comment belongs to post
        if ($comment->post_id !== $post->id) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        $comment->delete();

        // Decrement post comment count
        $post->decrement('comments_count');

        return response()->json([
            'message' => 'Comment deleted successfully',
        ]);
    }
}
