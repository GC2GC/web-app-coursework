<?php

namespace App\Notifications;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CommentCommented extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Comment $originalComment,
        public Comment $newComment,
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
        $this->originalComment->load('post');
        
        return [
            'post_id' => $this->originalComment->post_id,
            'post_title' => $this->originalComment->post->title ?? 'Post',
            'original_comment_id' => $this->originalComment->id,
            'new_comment_id' => $this->newComment->id,
            'commenter_id' => $this->commenter->id,
            'commenter_name' => $this->commenter->first_name . ' ' . $this->commenter->last_name,
            'message' => $this->commenter->first_name . ' ' . $this->commenter->last_name . ' replied to your comment',
        ];
    }
}
