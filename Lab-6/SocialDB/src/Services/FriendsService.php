<?php

namespace SocialDB\Services;

use PDO;
use SocialDB\Models\FriendRequestStatus;
use SocialDB\Models\UserModel;
use SocialDB\Repositories\FriendRequestRepository;
use SocialDB\Repositories\UserRepository;

class FriendsService
{
    private FriendRequestRepository $friendRequestRepository;
    private UserRepository $userRepository;

    public function __construct(PDO $connection)
    {
        $this->friendRequestRepository = new FriendRequestRepository($connection);
        $this->userRepository = new UserRepository($connection);
    }

    /**
     * @param UserModel $user
     * @return UserModel[]
     */
    public function getFriends(UserModel $user): array
    {
        $userId = $user->id;
        $friendRequests = $this->friendRequestRepository->getBySenderOrRecipientIds($userId, $userId);

        /** @var int[] $friendsId */
        $friendsId = [];

        /** @var int[] $notFriendsId */
        $notFriendsId = [];


        foreach ($friendRequests as $request) {
            $requestFrom = $request->fromUserId;
            $requestTo = $request->toUserId;

            $potentialFriendId = $requestFrom === $userId ? $requestTo : $requestFrom;

            if ($request->status === FriendRequestStatus::DECLINED) {
                $notFriendsId[] = $potentialFriendId;
                continue;
            }

            $potentialSymmetricRequest = $this->friendRequestRepository->getBySenderAndRecipientIds($requestTo, $requestFrom);

            if ($potentialSymmetricRequest !== null) {

                if ($request->status !== FriendRequestStatus::DECLINED) {
                    $friendsId[] = $potentialFriendId;
                    continue;
                } else {
                    continue;
                }
            }
            if ($request->status === FriendRequestStatus::ACCEPTED) {
                $friendsId[] = $potentialFriendId;
                continue;
            } else {
                continue;
            }
        }

        $friendsId = array_diff(array_unique($friendsId), array_unique($notFriendsId));

        return $this->userRepository->getUsersFromIds($friendsId);
    }

    public function isFriend(int $userId, int $userForChekId): bool
    {
        $user = $this->userRepository->getById($userId);
        $friends = $this->getFriends($user);

        return count(array_filter($friends, fn($friend) => $friend->id === $userForChekId)) === 1;
    }
}
