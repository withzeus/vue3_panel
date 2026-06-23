<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('users.index');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        if ($user->id === $model->id) {
            return true;
        }
        return $user->can('users.show');
    }

    /**
     * Determine whether the user can view the profile.
     */
    public function viewProfile(User $user, User $model): bool
    {
        if ($user->id !== $model->id) {
            return false;
        }

        return $user->can('users.profile');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('users.create');
    }

    public function store(User $user): bool
    {
        return $user->can('users.store');
    }

    /**
     * Determine whether the user can update the model.
     */

    public function edit(User $user, User $model): bool
    {
        return $user->can('users.edit');
    }

    public function update(User $user, User $model): bool
    {
        return $user->can('users.update');
    }

    public function updateProfile(User $user, User $model): bool
    {
        if ($user->id !== $model->id) {
            return false;
        }

        return $user->can('users.profile.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        if ($user->id === $model->id) {
            return false;
        }

        return $user->can('users.destroy');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
