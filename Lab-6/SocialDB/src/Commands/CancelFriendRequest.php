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

class CancelFriendRequest extends Command
{
    protected static $defaultName = 'social:cancel-friend-request';

    private FriendRequestRepository $friendRequestRepository;
    private UserRepository $userRepository;

    public function __construct(PDO $connection)
    {
        parent::__construct();

        $this->friendRequestRepository = new FriendRequestRepository($connection);
        $this->userRepository = new UserRepository($connection);
    }

    protected function configure()
    {
        $this
            ->setDescription('Cancel friend request')
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
            $this->friendRequestRepository->remove($usedUserId, $anotherUserId);
            $output->writeln('Request was canceled');
            return self::SUCCESS;
        }

        $output->writeln('There is no matching request');
        return self::FAILURE;
    }
}
