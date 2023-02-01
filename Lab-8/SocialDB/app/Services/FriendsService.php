<?php


namespace App\Services;


use App\DAO\FriendRequestDAO;
use App\DBModels\User;
use App\Models\FriendRequestStatus;
use Illuminate\Database\Eloquent\Collection;

class FriendsService
{

    public function __construct()
    {

    }

    /**
     * @param int $userId
     * @return Collection
     */
    public function getFriends(int $userId): Collection
    {
        $friends = Collection::empty();
        $friendRequests = FriendRequestDAO::getRequestsWithUser($userId);

        foreach ($friendRequests as $friendRequest) {

            if ($friendRequest->user_id_to === $userId) {

                if ($friendRequest->status === FriendRequestStatus::DECLINED || $this->isFriend($friendRequest->sender, $friends)) {
                    continue;
                }

                $symmetricDeclinedRequest = FriendRequestDAO::getSymmetricDeclinedRequest($friendRequest->sender->id, $userId);

                if ($friendRequest->status === FriendRequestStatus::ACCEPTED && !$symmetricDeclinedRequest) {
                    $friends->add($friendRequest->sender);
                    continue;
                }

                if (FriendRequestDAO::getSymmetricNotDeclinedRequest($friendRequest->sender->id, $userId) !== null) {
                    $friends->add($friendRequest->sender);
                    continue;
                }

            }

            if ($friendRequest->user_id_from === $userId) {
                if ($friendRequest->status === FriendRequestStatus::DECLINED || $this->isFriend($friendRequest->recipient, $friends)) {
                    continue;
                }

                $symmetricDeclinedRequest = FriendRequestDAO::getSymmetricDeclinedRequest($userId, $friendRequest->recipient->id);

                if ($friendRequest->status === FriendRequestStatus::ACCEPTED && !$symmetricDeclinedRequest) {
                    $friends->add($friendRequest->recipient);
                    continue;
                }

                if (FriendRequestDAO::getSymmetricNotDeclinedRequest($userId, $friendRequest->recipient->id)) {

                    $friends->add($friendRequest->recipient);
                    continue;
                }

            }
        }

        return $friends;
    }

    /**
     * @param User $user
     * @param Collection $friends
     * @return bool
     */
    public function isFriend(User $user, Collection $friends): bool
    {
        return $friends->contains($user);
    }

    /**
     * @param Collection $friends
     * @return Collection
     */
    public function getOnlineFriends(Collection $friends): Collection
    {
        return $friends->filter(function ($value) {
            return $value->is_online;
        });
    }
}
