<?php

namespace App\Notifications;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PostCommented extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Post $post,
        public Comment $comment,
        public User $commenter
    ) {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'post_id' => $this->post->id,
            'post_title' => $this->post->title,
            'comment_id' => $this->comment->id,
            'commenter_id' => $this->commenter->id,
            'commenter_name' => $this->commenter->first_name . ' ' . $this->commenter->last_name,
            'message' => $this->commenter->first_name . ' ' . $this->commenter->last_name . ' commented on your post: ' . $this->post->title,
        ];
    }
}
