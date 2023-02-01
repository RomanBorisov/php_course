<?php


namespace Social\DataAccess;

use PDO;
use Social\Http\ViewModels\PostViewModel;
use Social\Models\PostModel;

class PostRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function add(int $id, int $authorId, string $sendDate, string $text): void
    {
        if (!$this->checkExistPost($id)) {
            $statement = $this->connection->prepare(
                "insert into posts(id, author_id, send_date, text) 
                          values (?, ?, ?, ?)"
            );

            $statement->execute(
                [
                    $id,
                    $authorId,
                    $sendDate,
                    $text
                ]
            );
        } else {
            throw new \Exception('Post with this id already exists');
        }
    }

    public function create(int $authorId, string $text): void
    {
        $statement = $this->connection->prepare(
            'insert into posts(author_id, send_date, text) 
                      values (?, NOW(), ?)'
        );

        $statement->execute([$authorId, $text]);
    }

    public function removePost(int $postId): void
    {
        $statement = $this->connection->prepare('delete from posts where id = ?');

        $statement->execute([$postId]);
    }

    public function checkExistPost(int $postId): bool
    {
        $statement = $this->connection->prepare('select * from posts where id = ?');

        $statement->execute([$postId]);

        return count($statement->fetchAll(PDO::FETCH_ASSOC)) !== 0;
    }

    /**
     * @param int[] $ids
     * @return PostViewModel[]
     */
    public function getListPostsByUserIds(array $ids): array
    {
        if (count($ids) === 0) {
            return [];
        }
        $in = str_repeat('?,', count($ids) - 1) . '?';
        $statement = $this->connection->prepare(
            "select id, author_id as authorId, text, send_date as sendDate, (select count(*) from likes where post_id = posts.id) as numberLikes
                      from posts
                      where author_id in ({$in})"
        );

        $statement->execute($ids);

        return $statement->fetchAll(PDO::FETCH_CLASS, PostViewModel::class);
    }

    /**
     * @param PostModel[] $posts
     */
    public function addPosts(array $posts): void
    {
        $statement = $this->connection->prepare("insert into posts(id,author_id, send_date, text) values (?,?,?,?)");

        foreach ($posts as $post) {
            $statement->execute([$post->id, $post->authorId, $post->sendDate, $post->text]);
        }
    }

    public function clear(): void
    {
        $this->connection->query('SET FOREIGN_KEY_CHECKS = 0; 
                                     TRUNCATE table posts');
    }
}
