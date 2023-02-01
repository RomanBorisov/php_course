<?php


namespace SocialDB\Commands;


use PDO;
use SocialDB\Models\FriendRequestStatus;
use SocialDB\Repositories\FriendRequestRepository;
use SocialDB\Repositories\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DeclineFriendRequest extends Command
{
    protected static $defaultName = 'social:decline-friend-request';

    private PDO $connection;
    private FriendRequestRepository $friendRequestRepository;
    private UserRepository $userRepository;

    public function __construct(PDO $connection)
    {
        parent::__construct();

        $this->connection = $connection;
        $this->friendRequestRepository = new FriendRequestRepository($connection);
        $this->userRepository = new UserRepository($connection);
    }

    protected function configure()
    {
        $this
            ->setDescription('Decline friend requst')
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

        $incomingRequest = $this->friendRequestRepository->getBySenderAndRecipientIds($anotherUserId, $usedUserId);

        if ($incomingRequest !== null && ($incomingRequest->status === FriendRequestStatus::SENDED || $incomingRequest->status === FriendRequestStatus::VIEWED)) {
            $this->friendRequestRepository->decline($anotherUserId, $usedUserId);
            $output->writeln('Request was declined');
            return self::SUCCESS;
        }

        $output->writeln('There is no matching request');
        return self::FAILURE;
    }
}
