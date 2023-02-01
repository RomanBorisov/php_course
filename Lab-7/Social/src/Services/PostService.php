<?php


namespace Social\Services;


use PDO;
use Social\Models\PostModel;
use Social\DataAccess\LikesRepository;
use Social\DataAccess\PostRepository;

class PostService
{
    private PDO $connection;
    private LikesRepository $likesRepository;
    private PostRepository $postRepository;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
        $this->likesRepository = new LikesRepository($connection);
        $this->postRepository = new PostRepository($connection);
    }

    /**
     * @param PostModel[] $posts
     */
    public function addPosts(array $posts): void
    {
        $this->likesRepository->clear();
        $this->postRepository->addPosts($posts);

        foreach ($posts as $post) {
            $this->likesRepository->attachLikesToPost($post->likes, $post);
        }
    }


}
