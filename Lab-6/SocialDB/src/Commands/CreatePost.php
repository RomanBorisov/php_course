<?php


namespace SocialDB\Commands;


use PDO;
use SocialDB\Repositories\PostRepository;
use SocialDB\Repositories\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreatePost extends Command
{
    protected static $defaultName = 'social:create-post';

    private PDO $connection;
    private PostRepository $postRepository;
    private UserRepository $userRepository;

    public function __construct(PDO $connection)
    {
        parent::__construct();

        $this->connection = $connection;
        $this->postRepository = new PostRepository($connection);
        $this->userRepository = new UserRepository($connection);
    }

    protected function configure()
    {
        $this
            ->setDescription('Create post')
            ->addArgument('authorId', InputArgument::REQUIRED, 'Author ID')
            ->addArgument('text', InputArgument::OPTIONAL, 'Text of post');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $authorId = $input->getArgument('authorId');
        $text = $input->getArgument('text');

        if (!is_numeric($authorId)) {
            $output->writeln('Wrong id format');
            return self::FAILURE;
        }

        if ($text === null) {
            $output->writeln('Please add text of post');
            return self::FAILURE;
        }

        if ($this->userRepository->getById($authorId) === null) {
            $output->writeln('Author does not found');
            return self::FAILURE;
        }

        $this->postRepository->add($authorId, $text);
        $output->writeln('Post created');
        return self::SUCCESS;
    }
}

