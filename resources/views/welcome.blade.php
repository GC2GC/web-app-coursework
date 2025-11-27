<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Share Your Thoughts</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="/" class="text-xl font-bold text-gray-900 dark:text-white">
                            {{ config('app.name', 'Laravel') }}
                        </a>
                    </div>
                    <div class="flex items-center space-x-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-200 text-sm font-medium">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-200 text-sm font-medium">
                                Login
                            </a>
                            <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                Register
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <main class="flex-1">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <div class="text-center">
                    <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white sm:text-5xl md:text-6xl">
                        <span class="block">Share Your Thoughts</span>
                        <span class="block text-indigo-600 dark:text-indigo-400 mt-2">Connect with Others</span>
                    </h1>
                    <p class="mt-3 max-w-md mx-auto text-base text-gray-500 dark:text-gray-400 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                        Create posts, share images, and engage with a community of like-minded individuals. 
                        Comment on posts, like what you enjoy, and build meaningful connections.
                    </p>
                    <div class="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8">
                        @auth
                            <div class="rounded-md shadow">
                                <a href="{{ route('dashboard') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10">
                                    Go to Dashboard
                                </a>
                            </div>
                        @else
                            <div class="rounded-md shadow">
                                <a href="{{ route('register') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10">
                                    Get Started
                                </a>
                            </div>
                            <div class="mt-3 rounded-md shadow sm:mt-0 sm:ml-3">
                                <a href="{{ route('login') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-gray-50 dark:bg-gray-800 dark:text-indigo-400 dark:hover:bg-gray-700 md:py-4 md:text-lg md:px-10">
                                    Sign In
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>

                <!-- Features Section -->
                <div class="mt-20">
                    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                            <div class="text-4xl mb-4">📝</div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Create Posts</h3>
                            <p class="text-gray-600 dark:text-gray-400">
                                Share your thoughts, ideas, and experiences with the community. Add images to make your posts more engaging.
                            </p>
                        </div>
                        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                            <div class="text-4xl mb-4">💬</div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Engage & Comment</h3>
                            <p class="text-gray-600 dark:text-gray-400">
                                Join conversations by commenting on posts. Share your perspective and connect with others.
                            </p>
                        </div>
                        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                            <div class="text-4xl mb-4">📊</div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Track Analytics</h3>
                            <p class="text-gray-600 dark:text-gray-400">
                                See how your posts perform with view counts, likes, and comment statistics.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 mt-auto">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                <p class="text-center text-sm text-gray-500 dark:text-gray-400">
                    &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.
                </p>
            </div>
        </footer>
    </div>
</body>
</html>
