@extends('layouts.app')

@section('title', $user->first_name . ' ' . $user->last_name)

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <!-- User Info -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                {{ $user->first_name }} {{ $user->last_name }}
            </h1>
            <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $user->email }}</p>
            @if($user->is_administrator)
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                Administrator
            </span>
            @endif
        </div>

        <!-- Posts Section -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Posts ({{ $user->posts->count() }})</h2>
            @if($user->posts->count() > 0)
            <div class="space-y-4">
                @foreach($user->posts as $post)
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                        <a href="{{ route('posts.show', $post) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">
                            {{ $post->title }}
                        </a>
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-3">
                        {{ \Illuminate\Support\Str::limit($post->content, 200) }}
                    </p>
                    <div class="flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
                        <span>{{ $post->created_at->format('M d, Y') }}</span>
                        <span>•</span>
                        <span>👁️ {{ $post->views_count }} views</span>
                        <span>❤️ {{ $post->likes_count }} likes</span>
                        <span>💬 {{ $post->comments_count }} comments</span>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-8 text-center">
                <p class="text-gray-500 dark:text-gray-400">This user has not created any posts yet.</p>
            </div>
            @endif
        </div>

        <!-- Comments Section -->
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Comments ({{ $user->comments->count() }})</h2>
            @if($user->comments->count() > 0)
            <div class="space-y-4">
                @foreach($user->comments as $comment)
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <div class="flex items-start justify-between mb-2">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                                Comment on: <a href="{{ route('posts.show', $comment->post) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                                    {{ $comment->post->title }}
                                </a>
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $comment->created_at->format('M d, Y g:i A') }}
                            </p>
                        </div>
                    </div>
                    <p class="text-gray-700 dark:text-gray-300">{{ $comment->content }}</p>
                </div>
                @endforeach
            </div>
            @else
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-8 text-center">
                <p class="text-gray-500 dark:text-gray-400">This user has not made any comments yet.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

