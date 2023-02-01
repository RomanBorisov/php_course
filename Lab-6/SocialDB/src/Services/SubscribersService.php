<?php

namespace SocialDB\Services;

use PDO;
use SocialDB\Models\FriendRequestModel;
use SocialDB\Models\FriendRequestStatus;
use SocialDB\Models\UserModel;
use SocialDB\Repositories\FriendRequestRepository;
use SocialDB\Repositories\UserRepository;

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
            $user = $this->userRepository->getById($subscriberId);
            if (!in_array($user, $friends)) {
                $subscribers[] = $user;
            }
        }


        return $subscribers;
    }
}
