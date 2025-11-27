<?php

namespace App\Notifications;

use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PostLiked extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Post $post,
        public User $liker
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
            'liker_id' => $this->liker->id,
            'liker_name' => $this->liker->first_name . ' ' . $this->liker->last_name,
            'message' => $this->liker->first_name . ' ' . $this->liker->last_name . ' liked your post: ' . $this->post->title,
        ];
    }
}
