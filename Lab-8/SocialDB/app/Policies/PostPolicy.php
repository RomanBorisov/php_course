<?php

namespace App\Policies;

use App\DBModels\Post;
use App\DBModels\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function delete(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }
}
