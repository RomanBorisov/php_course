<?php


namespace Social\DataAccess;

use PDO;
use Social\Models\LikeModel;
use Social\Models\PostModel;

class LikesRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function likePost(int $userId, int $postId): void
    {
        $statement = $this->connection->prepare('insert into likes(user_id, post_id) values (?, ?)');

        $statement->execute([$userId, $postId]);
    }

    public function removeLike(int $userId, int $postId): void
    {
        $statement = $this->connection->prepare('delete from likes where post_id = ? and user_id = ?');

        $statement->execute([$postId, $userId]);
    }

    public function checkExistLike(int $userId, int $postId): bool
    {
        $statement = $this->connection->prepare('select * from likes where post_id = ? and user_id = ?');

        $statement->execute([$postId, $userId]);

        return count($statement->fetchAll(PDO::FETCH_ASSOC)) !== 0;
    }

    public function clear(): void
    {
        $this->connection->query('SET FOREIGN_KEY_CHECKS = 0; 
                                     TRUNCATE table likes');
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
}
