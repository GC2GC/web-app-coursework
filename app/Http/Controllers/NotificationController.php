<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display all notifications for the authenticated user.
     */
    public function index()
    {
        $notifications = auth()->user()->notifications()->paginate(20);
        
        return view('notifications.index', [
            'notifications' => $notifications,
        ]);
    }

    /**
     * Mark a notification as read.
     */
    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->find($id);
        
        if ($notification) {
            $notification->markAsRead();
        }

        return back();
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return back()->with('success', 'All notifications marked as read.');
    }
}

