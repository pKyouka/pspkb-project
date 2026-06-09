<?php

namespace App\Policies;

use App\Models\Page;
use App\Models\User;

class PagePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('super_admin', 'admin', 'editor', 'author');
    }

    public function view(User $user, Page $page): bool
    {
        if ($user->hasRole('super_admin', 'admin', 'editor')) {
            return true;
        }
        return $user->hasRole('author') && $page->created_by === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('super_admin', 'admin', 'editor', 'author');
    }

    public function update(User $user, Page $page): bool
    {
        if ($user->hasRole('super_admin', 'admin')) {
            return true;
        }
        if ($user->hasRole('editor')) {
            return true;
        }
        return $user->hasRole('author') && $page->created_by === $user->id;
    }

    public function delete(User $user, Page $page): bool
    {
        if ($user->hasRole('super_admin', 'admin')) {
            return true;
        }
        return $user->hasRole('author') && $page->created_by === $user->id;
    }

    public function publish(User $user): bool
    {
        return $user->hasRole('super_admin', 'admin', 'editor');
    }
}
