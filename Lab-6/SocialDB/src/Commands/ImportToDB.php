<?php


namespace SocialDB\Commands;


use PDO;
use SocialDB\Repositories\FriendRequestRepository;
use SocialDB\Repositories\UserRepository;
use SocialDB\Services\PostService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportToDB extends Command
{
    protected static $defaultName = 'social:import-to-db';

    private UserRepository $userRepository;
    private FriendRequestRepository $friendRequestRepository;
    private PostService $postService;

    public function __construct(PDO $connection)
    {
        parent::__construct();

        $this->userRepository = new UserRepository($connection);
        $this->friendRequestRepository = new FriendRequestRepository($connection);
        $this->postService = new PostService($connection);
    }

    protected function configure()
    {
        $this
            ->setDescription('Import from JSON file to DB')
            ->addArgument('fileName', InputArgument::REQUIRED, 'File for import');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $fileName = $input->getArgument('fileName');

        switch ($fileName) {
            case "users.json":
            {
                $users = json_decode(file_get_contents("Data/users.json"));

                foreach ($users as $user) {
                    $user->password = '12345';
                }

                $this->userRepository->addUsers($users);
                break;
            }
            case "friends.json":
            {
                $requests = json_decode(file_get_contents("Data/friends.json"));
                $this->friendRequestRepository->addRequests($requests);
                break;
            }
            case "posts.json":
            {
                $posts = json_decode(file_get_contents("Data/posts.json"));
                $this->postService->addPosts($posts);

                break;
            }
            default:
            {
                $output->writeln('File does not found');
                return self::FAILURE;
            }

        }
        return self::SUCCESS;
    }
}
