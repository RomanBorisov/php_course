<?php


namespace App\DAO;


use App\DBModels\Post;

class LikeDAO
{
    /**
     * @param Post $post
     * @param int $userId
     */
    public function addLikeToPostByUser(Post $post, int $userId)
    {
        $post->likes()->create([
            'user_id' => $userId,
        ]);
    }

    public function removeLikeToPostByUser(Post $post, int $userId)
    {
        $post->likes()->where([
            'user_id' => $userId,
        ])->delete();
    }
}
