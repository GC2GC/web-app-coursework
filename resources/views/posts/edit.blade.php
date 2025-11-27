@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Edit Post</h1>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('title') border-red-500 @enderror">
                        @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Content</label>
                        <textarea name="content" id="content" rows="10" required
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('content') border-red-500 @enderror">{{ old('content', $post->content) }}</textarea>
                        @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    @if($post->image_path)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Current Image</label>
                        <img src="{{ asset('storage/' . $post->image_path) }}" alt="{{ $post->title }}" class="max-w-md rounded-lg">
                    </div>
                    @endif

                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ $post->image_path ? 'Replace Image' : 'Add Image (optional)' }}
                        </label>
                        <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/jpg,image/gif"
                               class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900 dark:file:text-indigo-300">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Accepted formats: JPEG, PNG, JPG, GIF. Max size: 2MB</p>
                        @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end space-x-4">
                    <a href="{{ route('posts.show', $post) }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">
                        Cancel
                    </a>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md">
                        Update Post
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

