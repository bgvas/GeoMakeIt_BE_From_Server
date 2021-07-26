<?php

namespace App\Policies;

use App\Models\Plugin;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PluginPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any plugins.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->can('plugin:view');
    }

    /**
     * Determine whether the user can view the plugin.
     *
     * @param  \App\User  $user
     * @param  \App\Plugin  $plugin
     * @return mixed
     */
    public function view(User $user, Plugin $plugin)
    {
        return $user->can('plugin:view');
    }

    /**
     * Determine whether the user can create plugins.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->can('plugin:create');
    }

    /**
     * Determine whether the user can update the plugin.
     *
     * @param  \App\User  $user
     * @param  \App\Plugin  $plugin
     * @return mixed
     */
    public function update(User $user, Plugin $plugin)
    {
        if($user->can('plugin:edit')) {
            return $user->id === $plugin->user_id;
        }
    }

    /**
     * Determine whether the user can delete the plugin.
     *
     * @param  \App\User  $user
     * @param  \App\Plugin  $plugin
     * @return mixed
     */
    public function delete(User $user, Plugin $plugin)
    {
        return $user->can('plugin:delete');
    }

    /**
     * Determine whether the user can restore the plugin.
     *
     * @param  \App\User  $user
     * @param  \App\Plugin  $plugin
     * @return mixed
     */
    public function restore(User $user, Plugin $plugin)
    {
        return $user->can('plugin:delete');
    }

    /**
     * Determine whether the user can permanently delete the plugin.
     *
     * @param  \App\User  $user
     * @param  \App\Plugin  $plugin
     * @return mixed
     */
    public function forceDelete(User $user, Plugin $plugin)
    {
        return $user->can('plugin:delete');
//        return false;
    }
}
