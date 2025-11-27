@extends('layouts.app')

@section('title', 'Register New User')

@section('content')
<div class="max-w-2xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="mb-4">
            <a href="{{ route('users.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">
                ← Back to Users
            </a>
        </div>
        
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Register New User Account</h1>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                <div class="space-y-4">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">First Name</label>
                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('first_name') border-red-500 @enderror">
                        @error('first_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Last Name</label>
                        <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('last_name') border-red-500 @enderror">
                        @error('last_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('email') border-red-500 @enderror">
                        @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                        <input type="password" name="password" id="password" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('password') border-red-500 @enderror">
                        @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>

                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" name="is_administrator" value="1" {{ old('is_administrator') ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Make this user an Administrator</span>
                        </label>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end space-x-4">
                    <a href="{{ route('users.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">
                        Cancel
                    </a>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md">
                        Register User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

