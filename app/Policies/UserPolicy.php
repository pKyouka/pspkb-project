<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('super_admin', 'admin');
    }

    public function view(User $user, User $model): bool
    {
        return $user->hasRole('super_admin', 'admin') || $user->id === $model->id;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('super_admin', 'admin');
    }

    public function update(User $user, User $model): bool
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }
        if ($user->hasRole('admin') && !$model->hasRole('super_admin')) {
            return true;
        }
        return $user->id === $model->id;
    }

    public function delete(User $user, User $model): bool
    {
        if ($user->id === $model->id) {
            return false; // Can't delete yourself
        }
        if ($user->hasRole('super_admin')) {
            return true;
        }
        return $user->hasRole('admin') && !$model->hasRole('super_admin');
    }
}
