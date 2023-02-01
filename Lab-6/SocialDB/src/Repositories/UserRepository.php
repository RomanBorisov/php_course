<?php

namespace SocialDB\Repositories;

use PDO;
use SocialDB\Models\UserModel;

class UserRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }


    public function getById(int $userId): ?UserModel
    {
        $statement = $this->connection->prepare("
            select id, name, gender, date_of_birth as dateOfBirth, last_visit as lastVisit, is_online as online 
            from users
            where id = ?");

        $statement->execute([$userId]);

        $result = $statement->fetchObject(UserModel::class);

        return $result !== false ? $result : null;
    }

    /**
     * @param array $usersId
     * @return UserModel[]
     */
    public function getUsersFromIds(array $usersId): array
    {
        $in = implode(',', array_map('intval', $usersId));

        $statement = $this->connection->prepare("
            select id, name, gender, date_of_birth as dateOfBirth, last_visit as lastVisit, is_online as online 
            from users
            where id in ($in)");

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS, UserModel::class);
    }

    /**
     * @param string $userName
     * @return UserModel[]
     */
    public function getByName(string $userName): array
    {
        $statement = $this->connection->prepare("
            select id, name, gender, date_of_birth as dateOfBirth, last_visit as lastVisit, is_online as online 
            from users
            where name = ?");

        $statement->execute([$userName]);

        return $statement->fetchAll(PDO::FETCH_CLASS, UserModel::class);
    }

    /**
     * @param UserModel[] $users
     */
    public function addUsers(array $users): void
    {
        $this->clear();

        $statement = $this->connection->prepare("insert into users(id, name, password, gender, date_of_birth, last_visit, is_online) values (?,?,?,?,?,?,?)");
        foreach ($users as $user) {
            $statement->execute([$user->id, $user->name, $user->password, $user->gender, $user->dateOfBirth, $user->lastVisit, $user->online ? 1 : 0]);
        }
    }

    public function clear(): void
    {
        $this->connection->query('SET FOREIGN_KEY_CHECKS = 0; 
                                    TRUNCATE table users');
    }

}
