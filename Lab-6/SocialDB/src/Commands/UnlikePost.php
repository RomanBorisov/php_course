<?php


namespace SocialDB\Commands;


use PDO;
use SocialDB\Repositories\LikesRepository;
use SocialDB\Repositories\PostRepository;
use SocialDB\Repositories\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UnlikePost extends Command
{
    protected static $defaultName = 'social:unlike-post';

    private PDO $connection;
    private LikesRepository $likeRepository;
    private PostRepository $postRepository;
    private UserRepository $userRepository;

    public function __construct(PDO $connection)
    {
        parent::__construct();

        $this->connection = $connection;
        $this->likeRepository = new LikesRepository($connection);
        $this->postRepository = new PostRepository($connection);
        $this->userRepository = new UserRepository($connection);
    }

    protected function configure()
    {
        $this
            ->setDescription('Unlike post')
            ->addArgument('postId', InputArgument::REQUIRED, 'Post id')
            ->addArgument('userId', InputArgument::REQUIRED, 'User id');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $postId = $input->getArgument('postId');
        $userId = $input->getArgument('userId');

        if (!is_numeric($userId) || !is_numeric($postId)) {
            $output->writeln('Wrong id format');

            return self::FAILURE;
        }

        if ($this->postRepository->getById($postId) === null) {
            $output->writeln('There is no post with this id');
            return self::FAILURE;
        }

        if ($this->userRepository->getById($userId) === null) {
            $output->writeln('There is no user with this id');
            return self::FAILURE;
        }

        if ($this->likeRepository->checkForLike($postId, $userId) === 0) {
            $output->writeln('You have not liked this post!');
            return self::FAILURE;
        }

        $this->likeRepository->unlike($postId, $userId);
        $output->writeln('Post unliked');

        return self::SUCCESS;
    }
}
