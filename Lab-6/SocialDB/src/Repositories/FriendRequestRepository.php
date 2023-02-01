<?php


namespace SocialDB\Repositories;


use PDO;
use SocialDB\Models\FriendRequestModel;
use SocialDB\Models\UserModel;

class FriendRequestRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function create(int $senderId, int $recipientId): void
    {
        $statement = $this->connection->prepare("insert into friends(user_from_id, user_to_id, friend_status, send_date) values (?,?,?,now())");

        $statement->execute([$senderId, $recipientId, 0]);
    }

    public function remove(int $senderId, int $recipientId): void
    {
        $statement = $this->connection->prepare("delete from friends where user_from_id = ? and user_to_id = ?");

        $statement->execute([$senderId, $recipientId]);
    }

    public function decline(int $senderId, int $recipientId): void
    {
        $statement = $this->connection->prepare("update friends 
                                                    set friend_status = 3
                                                    where user_from_id = ? and user_to_id = ?");

        $statement->execute([$senderId, $recipientId]);
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

    /**
     * @param UserModel $user
     * @return UserModel[]
     */
    public function getNewFriendRequests(UserModel $user): array
    {
        $statement = $this->connection->prepare(
            "select (select name from users where id = friends.user_from_id) as name from users
                    join friends on users.id = friends.user_to_id
                    where users.id = ? and friends.friend_status = 0 and friends.send_date > users.last_visit");

        $statement->execute([$user->id]);

        return $statement->fetchAll(PDO::FETCH_CLASS, UserModel::class);
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
     * @param FriendRequestModel[] $requests
     */
    public function addRequests(array $requests): void
    {
        $this->clear();

        $statement = $this->connection->prepare('insert into friends(user_from_id,user_to_id, friend_status, send_date) values (?,?,?,?)');

        foreach ($requests as $request) {
            $statement->execute([$request->toUserId, $request->fromUserId, $request->status, $request->sendDate]);
        }
    }

    public function clear(): void
    {
        $this->connection->query('SET FOREIGN_KEY_CHECKS = 0; 
                                    TRUNCATE table friends');
    }


}
