<?php

namespace Social\Services;

use PDO;
use Social\DataAccess\FriendRequestRepository;
use Social\DataAccess\UserRepository;
use Social\Models\FriendRequestModel;
use Social\Models\FriendRequestStatus;
use Social\Models\UserModel;

class SubscribersService
{
    private PDO $connection;
    private UserRepository $userRepository;
    private FriendRequestRepository $friendRequestRepository;
    private FriendsService $friendService;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
        $this->userRepository = new UserRepository($connection);
        $this->friendRequestRepository = new FriendRequestRepository($connection);
        $this->friendService = new FriendsService($connection);
    }

    /**
     * @param UserModel $user
     * @return UserModel[]
     * @throws \Exception
     */
    public function getSubscribers(UserModel $user): array
    {
        $requests = $this->friendRequestRepository->getByRecipientId($user->id);

        /** @var UserModel[] $subscribers */
        $friends = $this->friendService->getFriends($user);

        /** @var UserModel[] $subscribers */
        $subscribers = [];

        /** @var FriendRequestModel[] $potentialSubscriberRequests */
        $potentialSubscriberRequests = array_filter($requests, fn($request) => $request->status !== FriendRequestStatus::ACCEPTED);

        /** @var int[] $subscribersId */
        $subscribersId = array_map(fn($request) => $request->fromUserId, $potentialSubscriberRequests);

        foreach ($subscribersId as $subscriberId) {
            $user = $this->userRepository->getUserById($subscriberId);
            if (!in_array($user, $friends)) {
                $subscribers[] = $user;
            }
        }


        return $subscribers;
    }
}
