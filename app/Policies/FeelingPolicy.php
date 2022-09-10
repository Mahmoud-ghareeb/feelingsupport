<?php

namespace App\Policies;

use App\Models\Feeling;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FeelingPolicy
{
    use HandlesAuthorization;


    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Feeling  $feeling
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function show(User $user, Feeling $feeling)
    {
        return (($user->id == $feeling->user_id) || ($feeling->type == 1));
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Feeling  $feeling
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function showComment(User $user, Feeling $feel)
    {
        return $user->id == $feel->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, Feeling $feeling)
    {
        return ($user->id == $feeling->user_id || $feeling->type);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Feeling  $feeling
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function share(User $user, Feeling $feeling)
    {
        return $user->id == $feeling->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Feeling  $feeling
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Feeling $feeling)
    {
        return $user->id == $feeling->user_id;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Feeling  $feeling
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function makePrivate(User $user, Feeling $feeling)
    {
        return $user->id == $feeling->user_id;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Feeling  $feeling
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function makePublic(User $user, Feeling $feeling)
    {
        return $user->id == $feeling->user_id;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Feeling  $feeling
     * @return \Illuminate\Auth\Access\Response|bool
     */
    // public function createComment(User $user, Feeling $feeling)
    // {
    //     return 1; //$user->id != $feeling->user_id;
    // }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Feeling  $feeling
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function like(User $user, Feeling $feeling)
    {
        return $user->id != $feeling->user_id;
    }
}
