<?php


namespace SocialDB\Commands;


use DateTime;
use PDO;
use SocialDB\Models\UserModel;
use SocialDB\Repositories\FriendRequestRepository;
use SocialDB\Repositories\LikesRepository;
use SocialDB\Repositories\PostRepository;
use SocialDB\Repositories\UserRepository;
use SocialDB\Services\FriendsService;
use SocialDB\Services\SubscribersService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetUserInfo extends Command
{
    protected static $defaultName = 'social:get-user-info';

    private PDO $connection;
    private UserRepository $userRepository;
    private FriendRequestRepository $friendRequestRepository;
    private PostRepository $postRepository;
    private LikesRepository $likeRepository;
    private FriendsService $friendsService;
    private SubscribersService $subsService;

    public function __construct(PDO $connection)
    {
        parent::__construct();

        $this->connection = $connection;
        $this->userRepository = new UserRepository($connection);
        $this->friendRequestRepository = new FriendRequestRepository($connection);
        $this->postRepository = new PostRepository($connection);
        $this->likeRepository = new LikesRepository($connection);
        $this->subsService = new SubscribersService($connection);
        $this->friendsService = new FriendsService($connection);
    }

    protected function configure()
    {
        $this
            ->setDescription('Get user info')
            ->addArgument('userName', InputArgument::REQUIRED, 'User name');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $userName = $input->getArgument('userName');

        $usersByName = $this->userRepository->getByName($userName);

        if (count($usersByName) === 0) {
            $output->writeln('User not found');

            return self::FAILURE;
        }

        foreach ($usersByName as $user) {

            $this->showVisualSeparator($output);
            $this->showUserInfo($user, $output);

            $this->showVisualSeparator($output);


            $friends = $this->friendsService->getFriends($user);
            $friendsCount = count($friends);

            $output->writeln("Friends: $friendsCount");
            foreach ($friends as $friend) {
                $this->showUserInfo($friend, $output);
            }

            $this->showVisualSeparator($output);
            $friendsOnline = array_filter($friends, fn($friend) => $friend->online);
            $friendsOnlineCount = count($friendsOnline);

            $output->writeln("Friends online: {$friendsOnlineCount}");
            foreach ($friendsOnline as $friendOnline) {
                $this->showUserInfo($friendOnline, $output);
            }

            $this->showVisualSeparator($output);
            $subscribers = $this->subsService->getSubscribers($user);
            $subscribersCount = count($subscribers);

            $output->writeln("Subscribers: $subscribersCount");
            foreach ($subscribers as $subscriber) {
                $this->showUserInfo($subscriber, $output);
            }

            $this->showVisualSeparator($output);
            $newRequestsCount = count($this->getNewRequestsUser($user));
            $output->writeln("New requests: {$newRequestsCount}");

            foreach ($this->getNewRequestsUser($user) as $userName) {
                $output->writeln("Name: {$userName}");
            }

            $this->showVisualSeparator($output);
            $output->writeln("News:");

            foreach ($friends as $friend) {
                $output->writeln("Friend: {$friend->name}");
                $friendPosts = $this->postRepository->getLatestPostsByAuthor($friend, $user->lastVisit);
                if (count($friendPosts) === 0) {
                    $output->writeln("No new posts for this friend");
                    continue;
                }
                foreach ($friendPosts as $friendPost) {
                    $likes = $this->likeRepository->getPostLikes($friendPost);
                    $output->writeln("Date: {$friendPost->sendDate}, Text: '{$friendPost->text}', Likes: {$likes}");
                }
            }

        }


        return self::SUCCESS;
    }

    /**
     * @param UserModel $user
     * @return string[]
     */
    private function getNewRequestsUser(UserModel $user): array
    {
        return array_map(fn($item) => $item->name, $this->friendRequestRepository->getNewFriendRequests($user));
    }

    private function getUserAge(UserModel $user): int
    {
        $now = new DateTime();
        return $now->diff(new DateTime($user->dateOfBirth))->y;
    }

    private function showUserInfo(UserModel $user, OutputInterface $output)
    {
        $output->writeln("Name: {$user->name}, Age: {$this->getUserAge($user)}");
    }

    private function showVisualSeparator(OutputInterface $output)
    {
        $output->writeln("--------------------------");
    }

}
