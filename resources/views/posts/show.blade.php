@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <!-- Post Header -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-6">
            <div class="flex justify-between items-start mb-4">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ $post->title }}</h1>
                    <div class="flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400 mb-4">
                        <span>By <a href="{{ route('users.show', $post->author) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ $post->author->first_name }} {{ $post->author->last_name }}</a></span>
                        <span>•</span>
                        <span>{{ $post->created_at->format('M d, Y g:i A') }}</span>
                    </div>
                </div>
                @can('update', $post)
                <div class="flex space-x-2">
                    <a href="{{ route('posts.edit', $post) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 text-sm font-medium">
                        Edit
                    </a>
                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this post?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 text-sm font-medium">
                            Delete
                        </button>
                    </form>
                </div>
                @endcan
            </div>

            <!-- Post Image -->
            @if($post->image_path)
            <div class="mb-4">
                <img src="{{ asset('storage/' . $post->image_path) }}" alt="{{ $post->title }}" class="w-full rounded-lg">
            </div>
            @endif

            <!-- Post Content -->
            <div class="prose dark:prose-invert max-w-none mb-4">
                <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $post->content }}</p>
            </div>

            <!-- Analytics -->
            <div class="flex items-center space-x-6 text-sm text-gray-500 dark:text-gray-400 border-t border-gray-200 dark:border-gray-700 pt-4">
                <span>👁️ {{ $post->views_count }} views</span>
                <span>❤️ {{ $post->likes_count }} likes</span>
                <span>💬 {{ $post->comments_count }} comments</span>
            </div>
        </div>

        <!-- Like Button -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 mb-6">
            <form action="{{ route('posts.like', $post) }}" method="POST" class="inline">
                @csrf
                @php
                    $hasLiked = \App\Services\AnalyticsService::hasLiked($post, auth()->id());
                @endphp
                <button type="submit" class="{{ $hasLiked ? 'bg-red-600 hover:bg-red-700 text-white' : 'bg-red-100 hover:bg-red-200 dark:bg-red-900 dark:hover:bg-red-800 text-red-700 dark:text-red-300' }} font-medium py-2 px-4 rounded-md">
                    ❤️ {{ $hasLiked ? 'Liked' : 'Like' }} ({{ $post->likes_count }})
                </button>
            </form>
        </div>

        <!-- Comments Section -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Comments ({{ $post->comments->count() }})</h2>

            <!-- Comment Form -->
            <form action="{{ route('posts.comments.store', $post) }}" method="POST" class="mb-6">
                @csrf
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Add a comment</label>
                    <textarea name="content" id="content" rows="3" required
                              class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('content') border-red-500 @enderror"
                              placeholder="Write your comment here..."></textarea>
                    @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mt-2">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md">
                        Post Comment
                    </button>
                </div>
            </form>

            <!-- Comments List -->
            @if($post->comments->count() > 0)
            <div class="space-y-4">
                @foreach($post->comments as $comment)
                <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="flex items-center space-x-2 mb-2">
                                <a href="{{ route('users.show', $comment->author) }}" class="font-semibold text-gray-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400">
                                    {{ $comment->author->first_name }} {{ $comment->author->last_name }}
                                </a>
                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $comment->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $comment->content }}</p>
                        </div>
                        @can('update', $comment)
                        <div class="flex space-x-2 ml-4">
                            <button onclick="editComment({{ $comment->id }})" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 text-sm">
                                Edit
                            </button>
                            <form action="{{ route('posts.comments.destroy', [$post, $comment]) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 text-sm">
                                    Delete
                                </button>
                            </form>
                        </div>
                        @endcan
                    </div>
                    <!-- Edit Comment Form (hidden by default) -->
                    <div id="edit-comment-{{ $comment->id }}" class="hidden mt-2">
                        <form action="{{ route('posts.comments.update', [$post, $comment]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <textarea name="content" rows="3" required
                                      class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ $comment->content }}</textarea>
                            <div class="mt-2 flex space-x-2">
                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium py-1 px-3 rounded-md">
                                    Save
                                </button>
                                <button type="button" onclick="cancelEdit({{ $comment->id }})" class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium py-1 px-3 rounded-md">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-gray-500 dark:text-gray-400">No comments yet. Be the first to comment!</p>
            @endif
        </div>
    </div>
</div>

<script>
function editComment(commentId) {
    // Hide all other edit forms
    document.querySelectorAll('[id^="edit-comment-"]').forEach(form => {
        form.classList.add('hidden');
    });
    // Show this edit form
    document.getElementById('edit-comment-' + commentId).classList.remove('hidden');
    // Scroll to the form
    document.getElementById('edit-comment-' + commentId).scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

function cancelEdit(commentId) {
    document.getElementById('edit-comment-' + commentId).classList.add('hidden');
}
</script>
@endsection

