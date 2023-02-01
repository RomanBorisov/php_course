<?php


namespace SocialDB\Commands;


use PDO;
use SocialDB\Models\FriendRequestStatus;
use SocialDB\Repositories\FriendRequestRepository;
use SocialDB\Repositories\UserRepository;
use SocialDB\Services\FriendsService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SendFriendRequest extends Command
{
    protected static $defaultName = 'social:send-friend-request';

    private PDO $connection;
    private FriendRequestRepository $friendRequestRepository;
    private UserRepository $userRepository;
    private FriendsService $friendsService;

    public function __construct(PDO $connection)
    {
        parent::__construct();

        $this->connection = $connection;
        $this->friendRequestRepository = new FriendRequestRepository($connection);
        $this->userRepository = new UserRepository($connection);
        $this->friendsService = new FriendsService($connection);
    }

    protected function configure()
    {
        $this
            ->setDescription('Send friend request')
            ->addArgument('usedUserId', InputArgument::REQUIRED, 'Used user id')
            ->addArgument('anotherUserId', InputArgument::REQUIRED, 'Id of user used for request');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $usedUserId = $input->getArgument('usedUserId');
        $anotherUserId = $input->getArgument('anotherUserId');


        if (!is_numeric($usedUserId) || !is_numeric($anotherUserId)) {
            $output->writeln('Wrong id format');

            return self::FAILURE;
        }

        if ($this->userRepository->getById($usedUserId) === null || $this->userRepository->getById($anotherUserId) === null) {
            $output->writeln('There is no user(s) with this id');
            return self::FAILURE;
        }

        $request = $this->friendRequestRepository->getBySenderAndRecipientIds($usedUserId, $anotherUserId);

        if ($request !== null && ($request->status === FriendRequestStatus::SENDED || $request->status === FriendRequestStatus::VIEWED)) {
            $output->writeln('You have already sent a request to this user. Please wait for answer.');
            return self::FAILURE;
        }

        if ($this->friendsService->isFriend($usedUserId, $anotherUserId)) {
            $output->writeln('This user is already your friend.');
            return self::FAILURE;
        }

        if ($request !== null && $request->status === FriendRequestStatus::DECLINED) {
            $output->writeln('You have already sent a request to this user and he rejected it. I am creating request again');

            $this->friendRequestRepository->remove($usedUserId, $anotherUserId);
            $this->friendRequestRepository->create($usedUserId, $anotherUserId);
            return self::SUCCESS;
        }

        $this->friendRequestRepository->create($usedUserId, $anotherUserId);

        $output->writeln('Request has been sent!');
        return self::SUCCESS;
    }
}
