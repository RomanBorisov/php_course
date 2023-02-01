<?php

namespace App\DataAccess;

use App\Utils\StringUtils;
use Illuminate\Database\DatabaseManager;
use PDO;

abstract class BaseRepository
{
    protected PDO $connection;
    protected string $tableName;

    public function __construct(DatabaseManager $databaseManager, string $tableName)
    {
        $this->connection = $databaseManager->getPdo();
        $this->tableName = $tableName;
    }

    protected function insert(array $valuesToInsert): int
    {
        $fields = array_keys($valuesToInsert);
        $values = array_values($valuesToInsert);

        $fieldsStr = implode(
            ', ',
            array_map(fn(string $x) => "`{$x}`", $fields)
        );
        $valuesStr = implode(
            ', ',
            array_map(fn($x) => '?', $values)
        );

        $sql = "insert into `{$this->tableName}` ({$fieldsStr}) values ({$valuesStr});";

        $statement = $this->connection->prepare($sql);

        $statement->execute($values);

        return $this->connection->lastInsertId();
    }

    protected function existsById(int $id): bool
    {
        $statement = $this->connection->prepare(
            "
            select *
            from `{$this->tableName}`
            where `id` = ?;
        "
        );

        $statement->execute([$id]);

        $result = $statement->fetchObject();

        return $result !== null && $result !== false;
    }

    protected function getEntityById(int $id, string $className): ?object
    {
        $statement = $this->connection->prepare(
            "
            select *
            from `{$this->tableName}`
            where `id` = ?;
        "
        );

        $statement->execute([$id]);

        $result = $statement->fetchObject();

        if ($result === null || $result === false) {
            return null;
        }

        $model = new $className();

        return $this->mapTableEntityToModel($result, $model);
    }

    protected function removeEntityById(int $id): void
    {
        $statement = $this->connection->prepare("delete from `{$this->tableName}` where id = ?");

        $statement->execute([$id]);
    }

    protected function getAllEntities(string $className): array
    {
        $statement = $this->connection->query(
            "
            select *
            from `{$this->tableName}`
        "
        );

        $results = $statement->fetchAll(PDO::FETCH_OBJ);

        return array_map(
            fn($x) => $this->mapTableEntityToModel($x, new $className()),
            $results
        );
    }

    protected function executeQuery(string $sql, array $bindings, string $className): array
    {
        $statement = $this->connection->prepare($sql);

        $statement->execute($bindings);

        $results = $statement->fetchAll(PDO::FETCH_OBJ);

        return array_map(
            fn($x) => $this->mapTableEntityToModel($x, new $className()),
            $results
        );
    }

    private function mapTableEntityToModel(object $source, object $destination): object
    {
        // hack for PHP 7.4
        // get_object_vars doesn't return uninitialized class fields
        $destinationFields = array_keys(get_class_vars(get_class($destination)));

        foreach ($destinationFields as $destinationField) {
            $snakeCaseModelField = StringUtils::camelToUnderscore($destinationField);

            if (isset($source->{$snakeCaseModelField})) {
                $destination->{$destinationField} = $source->{$snakeCaseModelField};
            }
        }

        return $destination;
    }
}
