<?php

declare(strict_types=1);

namespace Social\DataAccess;

use PDO;
use Social\Models\UserModel;

class UserRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function add(int $id, string $name, string $password, int $gender, string $dateOfBirth, string $lastVisit, int $isOnline): void
    {
        if (!$this->checkUserExist($id)) {
            $statement = $this->connection->prepare(
                "insert into users(id, name, password, gender, date_of_birth, last_visit, is_online)
                          values (?, ?, ?, ?, ?, ?, ?)"
            );


            $statement->execute(
                [
                    $id,
                    $name,
                    password_hash($password, PASSWORD_DEFAULT),
                    $gender,
                    $dateOfBirth,
                    $lastVisit,
                    $isOnline
                ]
            );
        } else {
            throw new \Exception('User with this id already exists');
        }
    }

    /**
     * @param array $usersId
     * @return UserModel[]
     */
    public function getUsersFromIds(array $usersId): array
    {
        if (count($usersId) === 0) {
            return [];
        }
        $in = implode(',', array_map('intval', $usersId));

        $statement = $this->connection->prepare("
            select id, name, gender, date_of_birth as dateOfBirth, last_visit as lastVisit, is_online as online 
            from users
            where id in  ({$in})");

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS, UserModel::class);
    }

    public function getUserById(int $id): UserModel
    {
        $statement = $this->connection->prepare(
            "select id, name,password, gender, date_of_birth as dateOfBirth, last_visit as lastVisit, is_online as isOnline
                      from users
                      where id = ?"
        );
        $statement->execute([$id]);
        $statement->setFetchMode(PDO::FETCH_CLASS, UserModel::class);
        $user = $statement->fetch();
        if ($user instanceof UserModel) {
            return $user;
        }
        throw new \Exception('User not found');
    }

    /**
     * @param string $name
     * @return int|null
     */
    public function getIdByName(string $name): ?int
    {
        $statement = $this->connection->prepare(
            "select id from users where name = ?"
        );
        $statement->execute([$name]);

        $result = $statement->fetch(PDO::FETCH_COLUMN);

        return $result === false ? null : (int)$result;
    }

    public function checkUserExist(int $id): bool
    {
        $statement = $this->connection->prepare(
            "select id from users where id = ?"
        );
        $statement->execute([$id]);

        return count($statement->fetchAll(PDO::FETCH_COLUMN)) !== 0;
    }

}
