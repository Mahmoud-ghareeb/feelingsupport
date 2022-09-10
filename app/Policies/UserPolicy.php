<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view, delete or add admin.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function rootPermission(User $user, User $model)
    {
        return $model->role == 'root admin';
    }

    /**
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function superAdminPermission(User $user, User $model)
    {
        return $model->role == 'super admin' or $model->role == 'root admin';
    }

    /**
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function adminPermission(User $user, User $model)
    {
        return $model->role == 'admin' or $model->role == 'super admin' or $model->role == 'root admin';
    }

    /**
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function moderatorPermission(User $user, User $model)
    {
        return $model->role == 'moderator' or $model->role == 'admin' or $model->role == 'super admin' or $model->role == 'root admin';
    }
}
