<?php


namespace App\DAO;


use App\DBModels\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User;

class PostDAO
{
    /**
     * @param User $user
     * @return mixed
     */
    public function getUserPosts(User $user)
    {
        return $user->posts();
    }

    public function getUserPostsWithLikes(User $user)
    {
        return $user->posts()->with(['user', 'likes'])->get();
    }

    /**
     * @return Builder|Builder[]|Collection
     */
    public function getPostsWithUserAndLikes()
    {
        return Post::with(['user', 'likes'])->get();
    }

    /**
     * @param int $userId
     * @param string $text
     */
    public function createPost(int $userId, string $text): void
    {
        Post::query()->create([
            'user_id' => $userId,
            'text' => $text
        ]);
    }

    /**
     * @param Post $post
     * @throws \Exception
     */
    public function deletePost(Post $post): void
    {
        $post->delete();
    }
}
