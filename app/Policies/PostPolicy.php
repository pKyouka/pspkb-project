<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('super_admin', 'admin', 'editor', 'author');
    }

    public function view(User $user, Post $post): bool
    {
        if ($user->hasRole('super_admin', 'admin', 'editor')) {
            return true;
        }
        return $user->hasRole('author') && $post->created_by === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('super_admin', 'admin', 'editor', 'author');
    }

    public function update(User $user, Post $post): bool
    {
        if ($user->hasRole('super_admin', 'admin')) {
            return true;
        }
        if ($user->hasRole('editor')) {
            return true;
        }
        return $user->hasRole('author') && $post->created_by === $user->id;
    }

    public function delete(User $user, Post $post): bool
    {
        if ($user->hasRole('super_admin', 'admin')) {
            return true;
        }
        return $user->hasRole('author') && $post->created_by === $user->id;
    }

    public function publish(User $user): bool
    {
        return $user->hasRole('super_admin', 'admin', 'editor');
    }
}
