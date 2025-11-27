@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Notifications</h1>
            @if(auth()->user()->unreadNotifications->count() > 0)
            <form action="{{ route('notifications.mark-all-read') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">
                    Mark all as read
                </button>
            </form>
            @endif
        </div>

        @if($notifications->count() > 0)
        <div class="space-y-3">
            @foreach($notifications as $notification)
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 {{ $notification->read_at ? '' : 'border-l-4 border-indigo-500' }}">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <p class="text-gray-900 dark:text-white">
                            @if($notification->type === 'App\Notifications\PostLiked')
                                <a href="{{ route('posts.show', $notification->data['post_id']) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">
                                    {{ $notification->data['message'] }}
                                </a>
                            @elseif($notification->type === 'App\Notifications\PostCommented')
                                <a href="{{ route('posts.show', $notification->data['post_id']) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">
                                    {{ $notification->data['message'] }}
                                </a>
                            @elseif($notification->type === 'App\Notifications\CommentCommented')
                                <a href="{{ route('posts.show', $notification->data['post_id']) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">
                                    {{ $notification->data['message'] }}
                                </a>
                            @else
                                {{ $notification->data['message'] ?? 'New notification' }}
                            @endif
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            {{ $notification->created_at->diffForHumans() }}
                        </p>
                    </div>
                    @if(!$notification->read_at)
                    <form action="{{ route('notifications.mark-read', $notification->id) }}" method="POST" class="ml-4">
                        @csrf
                        <button type="submit" class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                            Mark as read
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $notifications->links() }}
        </div>
        @else
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-8 text-center">
            <p class="text-gray-500 dark:text-gray-400">You have no notifications.</p>
        </div>
        @endif
    </div>
</div>
@endsection

