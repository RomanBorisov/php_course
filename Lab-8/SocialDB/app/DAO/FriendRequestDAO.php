<?php


namespace App\DAO;


use App\DBModels\FriendRequest;
use App\Models\FriendRequestStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class FriendRequestDAO
{
    /**
     * @param int $userId
     * @return Builder[]|Collection
     */
    public static function getRequestsWithUser(int $userId)
    {
        return FriendRequest::query()
            ->where('user_id_to', $userId)
            ->orWhere('user_id_from', $userId)
            ->get();
    }

    /**
     * @param int $senderId
     * @param int $recipientId
     * @return Builder|Model|object|null
     */
    public static function getSymmetricDeclinedRequest(int $senderId, int $recipientId)
    {
        return FriendRequest::query()
            ->where('user_id_to', $senderId)
            ->where('user_id_from', $recipientId)
            ->where('status', '=', FriendRequestStatus::DECLINED)
            ->first();
    }

    /**
     * @param int $senderId
     * @param int $recipientId
     * @return Builder|Model|object|null
     */
    public static function getSymmetricNotDeclinedRequest(int $senderId, int $recipientId)
    {
        return FriendRequest::query()
            ->where('user_id_to', $senderId)
            ->where('user_id_from', $recipientId)
            ->where('status', '!=', FriendRequestStatus::DECLINED)
            ->first();
    }

    /**
     * @param int $userId
     * @return Builder[]|Collection
     */
    public static function getUserSubscribers(int $userId)
    {
        return FriendRequest::query()
            ->where('user_id_to', $userId)
            ->where('status', '!=', FriendRequestStatus::ACCEPTED)
            ->get();
    }

    /**
     * @param int $userId
     * @return Builder[]|Collection
     */
    public static function getUserRequests(int $userId)
    {
        return FriendRequest::query()
            ->where('user_id_from', $userId)
            ->where('status', '!=', FriendRequestStatus::ACCEPTED)
            ->where('status', '!=', FriendRequestStatus::DECLINED)
            ->get();
    }

    /**
     * @param int $userId
     */
    public static function removeFromFriends(int $userId): void
    {
        self::removeRequestByParticipants(auth()->id(), $userId);
        self::removeRequestByParticipants($userId, auth()->id());
    }

    /**
     * @param int $userFromId
     * @param int $userToId
     */
    public static function removeRequestByParticipants(int $userFromId, int $userToId): void
    {
        FriendRequest::query()
            ->where('user_id_from', $userFromId)
            ->where('user_id_to', $userToId)
            ->delete();
    }

    /**
     * @param int $userFromId
     * @param int $userToId
     * @return Builder|Model|object|null
     */
    public static function getRequestByParticipants(int $userFromId, int $userToId)
    {
        return FriendRequest::query()
            ->where('user_id_from', $userFromId)
            ->where('user_id_to', $userToId)
            ->first();
    }

    /**
     * @param int $requestId
     * @param int $status
     */
    public static function updateRequestStatus(int $requestId, int $status): void
    {
        $friendRequest = FriendRequest::query()->find($requestId);
        $friendRequest->status = $status;
        $friendRequest->save();
    }

    /**
     * @param int $requestId
     * @throws \Exception
     */
    public static function removeRequest(int $requestId)
    {
        FriendRequest::query()->find($requestId)->delete();
    }
}
