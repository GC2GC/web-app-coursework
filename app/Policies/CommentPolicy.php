<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // All authenticated users can view comments
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Comment $comment): bool
    {
        return true; // All authenticated users can view individual comments
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true; // All authenticated users can create comments
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Comment $comment): bool
    {
        // User can update if they own the comment OR they are an administrator
        return $user->id === $comment->user_id || $user->is_administrator;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comment $comment): bool
    {
        // User can delete if they own the comment OR they are an administrator
        return $user->id === $comment->user_id || $user->is_administrator;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Comment $comment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Comment $comment): bool
    {
        return false;
    }
}
