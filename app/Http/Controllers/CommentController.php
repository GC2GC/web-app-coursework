<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Notifications\PostCommented;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * all comments for a post
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
     * single comment for a post
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
     * create comment
     */
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'content' => 'required|string|min:1|max:5000',
        ]);

        $comment = $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $validated['content'],
        ]);

        $post->increment('comments_count');
        
        // Send notification to post owner if they didn't comment on their own post
        $post->load('author');
        if ($post->author && $post->author->id !== auth()->id()) {
            $post->author->notify(new PostCommented($post, $comment, auth()->user()));
        }

        return redirect()->route('posts.show', $post)
            ->with('success', 'Comment added successfully.');
    }

    /**
     * update comment
     */
    public function update(Request $request, Post $post, Comment $comment)
    {
        // should belong to a blog post, if not return 404
        if ($comment->post_id !== $post->id) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        $this->authorize('update', $comment);

        $validated = $request->validate([
            'content' => 'required|string|min:1|max:5000',
        ]);
        $comment->update($validated);

        return response()->json([
            'message' => 'Comment updated',
            'data' => $comment,
        ]);
    }

    /**
     * delete a comment
     */
    public function destroy(Post $post, Comment $comment)
    {
        // should belong to a blog post, if not return 404
        if ($comment->post_id !== $post->id) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        $this->authorize('delete', $comment);

        $comment->delete();
        $post->decrement('comments_count');

        return redirect()->route('posts.show', $post)
            ->with('success', 'Comment deleted successfully.');
    }
}
