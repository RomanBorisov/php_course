<?php


namespace SocialDB\Repositories;


use PDO;
use SocialDB\Models\PostModel;
use SocialDB\Models\UserModel;

class PostRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param int $authorId
     * @param string $text
     */
    public function add(int $authorId, string $text): void
    {
        $statement = $this->connection->prepare("insert into posts(author_id, send_date, text) values (?,now(),?)");

        $statement->execute([$authorId, $text]);
    }

    /**
     * @param int $postId
     */
    public function removeById(int $postId): void
    {
        $statement = $this->connection->prepare("delete from posts where id = ?");

        $statement->execute([$postId]);
    }

    /**
     * @param PostModel[] $posts
     */
    public function addPosts(array $posts): void
    {
        $this->clear();
        $statement = $this->connection->prepare("insert into posts(id,author_id, send_date, text) values (?,?,?,?)");

        foreach ($posts as $post) {
            $statement->execute([$post->id, $post->authorId, $post->sendDate, $post->text]);
        }

    }

    /**
     * @param int $postId
     * @return PostModel|null
     */
    public function getById(int $postId): ?PostModel
    {
        $statement = $this->connection->prepare("select id, author_id as authorId, send_date as sendDate, text 
                                                from posts where id = ?");
        $statement->execute([$postId]);

        $result = $statement->fetchObject(PostModel::class);

        return $result !== false ? $result : null;
    }


    /**
     * @param UserModel $author
     * @param string $date
     * @return PostModel[]
     */
    public function getLatestPostsByAuthor(UserModel $author, string $date): array
    {
        $statement = $this->connection->prepare("select id, author_id as authorId, send_date as sendDate, text 
                                                from posts where author_id = ? and send_date > ?");

        $statement->execute([$author->id, $date]);

        return $statement->fetchAll(PDO:: FETCH_CLASS, PostModel::class);
    }

    public function clear(): void
    {
        $this->connection->query('SET FOREIGN_KEY_CHECKS = 0; 
                                     TRUNCATE table posts');
    }

}
