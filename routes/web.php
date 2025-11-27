<?php

use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Home route - show welcome page if not authenticated, otherwise redirect to dashboard
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
});

// Fortify handles authentication routes automatically:
// POST /login, POST /logout, POST /register, POST /password/reset, etc.
// We've configured the views in AppServiceProvider

// Protected routes - require authentication
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [PostController::class, 'index'])->name('dashboard');
    
    // Posts routes
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::post('/posts/{post}/like', [App\Http\Controllers\PostLikeController::class, 'toggle'])->name('posts.like');
    
    // Comments routes
    Route::post('/posts/{post}/comments', [App\Http\Controllers\CommentController::class, 'store'])->name('posts.comments.store');
    Route::put('/posts/{post}/comments/{comment}', [App\Http\Controllers\CommentController::class, 'update'])->name('posts.comments.update');
    Route::delete('/posts/{post}/comments/{comment}', [App\Http\Controllers\CommentController::class, 'destroy'])->name('posts.comments.destroy');
    
    // Notifications routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    
    // Users routes (admin only)
    Route::middleware(['admin'])->group(function () {
        Route::resource('users', UserController::class);
    });
    
    // Profile routes
    Route::get('/profile', function () {
        return redirect()->route('profile.edit');
    })->name('profile');
    
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
