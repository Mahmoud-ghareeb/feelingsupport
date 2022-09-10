<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Comment $comment)
    {
        return $comment->type;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, Comment $comment)
    {
        return $comment->type;
    }

    public function deleteComment(User $user, Comment $comment)
    {
        return $user->id == $comment->user_id;
    }
    
    public function showNotification(User $user, Comment $comment, Notification $noti)
    {
        return 1;//$comment->type == 1 and in_array($user->id, (array)$noti->replayed_on_ids);
    }
}
