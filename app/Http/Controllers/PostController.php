<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        return view('dashboard', [
            'posts' => $posts,
        ]);
    }

    /**
     * Show the form for creating a new post.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Get a single post with related data.
     * Automatically records a view for the post.
     */
    public function show(Post $post)
    {
        // Record a view for this post
        AnalyticsService::recordView($post);

        $post->load(['author', 'comments.author', 'likes.user']);

        return view('posts.show', [
            'post' => $post,
        ]);
    }

    /**
     * Create a new post.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        $post = Post::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'content' => $validated['content'],
            'image_path' => $imagePath,
        ]);

        return redirect()->route('posts.show', $post)
            ->with('success', 'Post created successfully.');
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        return view('posts.edit', [
            'post' => $post,
        ]);
    }

    /**
     * Update a post.
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($post->image_path) {
                Storage::disk('public')->delete($post->image_path);
            }
            $imagePath = $request->file('image')->store('posts', 'public');
            $validated['image_path'] = $imagePath;
        }

        $post->update($validated);

        return redirect()->route('posts.show', $post)
            ->with('success', 'Post updated successfully.');
    }

    /**
     * Delete a post.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        // Delete image if exists
        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }

        $post->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Post deleted successfully.');
    }
}
