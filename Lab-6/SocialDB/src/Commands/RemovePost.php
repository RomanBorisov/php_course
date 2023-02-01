<?php


namespace SocialDB\Commands;


use PDO;
use SocialDB\Repositories\PostRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RemovePost extends Command
{
    protected static $defaultName = 'social:remove-post';

    private PDO $connection;
    private PostRepository $postRepository;

    public function __construct(PDO $connection)
    {
        parent::__construct();

        $this->connection = $connection;
        $this->postRepository = new PostRepository($connection);
    }

    protected function configure()
    {
        $this
            ->setDescription('Like or unlike post')
            ->addArgument('postId', InputArgument::REQUIRED, 'Post id');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $postId = $input->getArgument('postId');


        if (!is_numeric($postId)) {
            $output->writeln('Wrong post id format');
            return self::FAILURE;
        }

        if ($this->postRepository->getById($postId) === null) {
            $output->writeln('Post does not found');
            return self::FAILURE;
        }

        $this->postRepository->removeById($postId);
        $output->writeln('Post removed');
        return self::SUCCESS;
    }
}
