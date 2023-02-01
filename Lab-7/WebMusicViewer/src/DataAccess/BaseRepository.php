<?php

namespace WebMusicViewer\DataAccess;

use PDO;

abstract class BaseRepository
{
    protected PDO $connection;
    private string $tableName;

    public function __construct(PDO $connection, string $tableName)
    {
        $this->connection = $connection;
        $this->tableName = $tableName;
    }

//    protected function insterEntity

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

        if ($result === null) {
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

    private function mapTableEntityToModel(object $source, object $destination): object
    {
        // hack for PHP 7.4
        // get_object_vars doesn't return uninitialized class fields
        $destinationFields = array_keys(get_class_vars(get_class($destination)));

        foreach ($destinationFields as $destinationField) {
            $snakeCaseModelField = camelToUnderscore($destinationField);

            if (isset($source->{$snakeCaseModelField})) {
                $destination->{$destinationField} = $source->{$snakeCaseModelField};
            }
        }

        return $destination;
    }
}
