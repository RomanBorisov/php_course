<?php


namespace Social\DataAccess;


use PDO;
use Social\Models\FriendRequestModel;
use Social\Models\FriendRequestStatus;

class FriendRequestRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getBySenderAndRecipientIds(int $senderId, int $recipientId): ?FriendRequestModel
    {
        $statement = $this->connection->prepare("select user_from_id as fromUserId, user_to_id as toUserId, send_date as sendDate, friend_status as status
                                                        from friends 
                                                        where user_from_id = :senderId and user_to_id = :recipientId");

        $statement->execute(['senderId' => $senderId, 'recipientId' => $recipientId]);

        $result = $statement->fetchObject(FriendRequestModel::class);

        return $result !== false ? $result : null;
    }

    /**
     * @param int $recipientId
     * @return FriendRequestModel[]
     */
    public function getByRecipientId(int $recipientId): array
    {
        $statement = $this->connection->prepare("select user_from_id as fromUserId, user_to_id as toUserId, send_date as sendDate, friend_status as status
                                                        from friends 
                                                        where user_to_id = :recipientId");

        $statement->execute(['recipientId' => $recipientId]);

        return $statement->fetchAll(PDO::FETCH_CLASS, FriendRequestModel::class);
    }

    /**
     * @param int $senderId
     * @param int $recipientId
     * @return FriendRequestModel[]
     */
    public function getBySenderOrRecipientIds(int $senderId, int $recipientId): array
    {
        $statement = $this->connection->prepare("select user_from_id as fromUserId, user_to_id as toUserId, send_date as sendDate, friend_status as status
                                                        from friends 
                                                        where user_from_id = :senderId or user_to_id = :recipientId");

        $statement->execute(['senderId' => $senderId, 'recipientId' => $recipientId]);

        return $statement->fetchAll(PDO::FETCH_CLASS, FriendRequestModel::class);
    }

    public function add(int $userFromId, int $userToId, int $status, string $sendDate): void
    {
        $statement = $this->connection->prepare(
            "insert into friends(user_from_id, user_to_id, friend_status, send_date)
                      values (?, ?, ?, ?)"
        );

        $statement->execute(
            [$userFromId, $userToId, $status, $sendDate]
        );
    }

    public function sendRequest(int $senderId, int $recipientId): void
    {
        $statement = $this->connection->prepare(
            "insert into friends(user_from_id, user_to_id, friend_status, send_date)
                      values (?, ?, 0, NOW())"
        );

        $statement->execute([$senderId, $recipientId]);
    }

    public function cancelRequest(int $senderId, int $recipientId): void
    {
        $statement = $this->connection->prepare(
            'delete from friends where user_from_id = ? and user_to_id =?'
        );

        $statement->execute([$senderId, $recipientId]);
    }

    public function rejectRequest(int $userId, int $senderId): void
    {
        $statement = $this->connection->prepare(
            'select id from friends where user_from_id = ? and user_to_id = ?'
        );

        $statement->execute([$senderId, $userId]);
        $requestId = $statement->fetch(PDO::FETCH_COLUMN);

        $statement = $this->connection->prepare(
            'update friends set friend_status = ? where id = ?'
        );

        $statement->execute([FriendRequestStatus::DECLINED, (int)$requestId]);
    }

    public function checkRequestExist(int $userFromId, int $userToId): bool
    {
        $statement = $this->connection->prepare(
            "select * from friends where user_from_id = ? and user_to_id = ?"
        );

        $statement->execute([$userFromId, $userToId]);

        return count($statement->fetchAll(PDO::FETCH_ASSOC)) !== 0;
    }

    /**
     * @param int $id
     * @return FriendRequestModel[]
     */
    public function getListNewFriendRequests(int $id): array
    {
        $statement = $this->connection->prepare(
            'select friends.id, friends.user_from_id as fromUserId, (select id from users where id = friends.user_from_id) as toUserId, friends.friend_status as status
                      from users
                             join friends on users.id = friends.user_to_id
                      where users.id = ?
                        and friends.friend_status = 0
                        and friends.send_date > users.last_visit'
        );
        $statement->execute([$id]);
        return $statement->fetchAll(PDO::FETCH_CLASS, FriendRequestModel::class);
    }

    /**
     * @param int $id
     * @return FriendRequestModel[]
     */
    public function getRequestsSendFromUser(int $id): array
    {
        $statement = $this->connection->prepare(
            "select id, user_from_id as fromUserId, user_to_id as toUserId, friend_status as status, send_date as sendDate
                      from friends
                      where user_from_id = ?"
        );
        $statement->execute([$id]);
        return $statement->fetchAll(PDO::FETCH_CLASS, FriendRequestModel::class);
    }

    /**
     * @param int $id
     * @return FriendRequestModel[]
     */
    public function getRequestsSendToUser(int $id): array
    {
        $statement = $this->connection->prepare(
            "select id, user_from_id as fromUserId, user_to_id as toUserId, friend_status as status, send_date as sendDate
                      from friends
                      where user_to_id = ?"
        );
        $statement->execute([$id]);
        return $statement->fetchAll(PDO::FETCH_CLASS, FriendRequestModel::class);
    }

}
