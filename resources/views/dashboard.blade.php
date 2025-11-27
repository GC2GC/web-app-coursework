@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    Welcome, {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}!
                </h1>
                @if(auth()->user()->is_administrator)
                <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4 inline-block">
                    <p class="font-semibold">Administrator Account</p>
                </div>
                @endif
            </div>
            <a href="{{ route('posts.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md">
                Create New Post
            </a>
        </div>

        <!-- Posts List -->
        <div class="space-y-4">
            @forelse($posts as $post)
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 hover:shadow-lg transition-shadow">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                            <a href="{{ route('posts.show', $post) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">
                                {{ $post->title }}
                            </a>
                        </h2>
                        @if($post->image_path)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $post->image_path) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover rounded-lg">
                        </div>
                        @endif
                        <p class="text-gray-600 dark:text-gray-400 mb-3 line-clamp-2">
                            {{ \Illuminate\Support\Str::limit($post->content, 150) }}
                        </p>
                        <div class="flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
                            <span>By {{ $post->author->first_name }} {{ $post->author->last_name }}</span>
                            <span>•</span>
                            <span>{{ $post->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex items-center space-x-6 text-sm text-gray-500 dark:text-gray-400">
                    <span>👁️ {{ $post->views_count }} views</span>
                    <span>❤️ {{ $post->likes_count }} likes</span>
                    <span>💬 {{ $post->comments_count }} comments</span>
                </div>
            </div>
            @empty
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-8 text-center">
                <p class="text-gray-500 dark:text-gray-400">No posts yet. Be the first to create one!</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection

