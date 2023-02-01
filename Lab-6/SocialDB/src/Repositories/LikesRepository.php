<?php


namespace SocialDB\Repositories;


use PDO;
use SocialDB\Models\PostModel;

class LikesRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getPostLikes(PostModel $post): int
    {
        $statement = $this->connection->prepare("select COUNT(*) from likes where post_id = ?");

        $statement->execute([$post->id]);

        return $statement->fetchColumn();
    }

    /**
     * @param int[] $likes
     * @param PostModel $post
     */
    public function attachLikesToPost(array $likes, $post): void
    {
        $statement = $this->connection->prepare("insert into likes(user_id, post_id) values (?,?)");

        foreach ($likes as $like) {
            $statement->execute([$like, $post->id]);
        }
    }

    /**
     * @param int $postId
     * @param int $userId
     */
    public function addLike(int $postId, int $userId): void
    {
        $statement = $this->connection->prepare("insert into likes(user_id, post_id) values (?,?)");

        $statement->execute([$userId, $postId]);
    }

    /**
     * @param int $postId
     * @param int $userId
     */
    public function unlike(int $postId, int $userId): void
    {
        $statement = $this->connection->prepare("DELETE FROM likes where user_id = ? and post_id = ?");

        $statement->execute([$userId, $postId]);

    }

    /**
     * @param int $postId
     * @param int $userId
     */
    public function checkForLike(int $postId, int $userId): int
    {
        $statement = $this->connection->prepare("select count(*) from likes where user_id = ? and post_id = ?");

        $statement->execute([$userId, $postId]);

        return $statement->fetchColumn();
    }

    public function clear(): void
    {
        $this->connection->query('SET FOREIGN_KEY_CHECKS = 0; 
                                     TRUNCATE table likes');
    }

}
