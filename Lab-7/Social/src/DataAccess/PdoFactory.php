<?php

namespace Social\DataAccess;

use PDO;

class PdoFactory
{
    public static function createFromEnv(): PDO
    {
        $host = $_ENV['DB_ADDRESS'];
        $dbname = $_ENV['DB_DATABASE_NAME'];
        $userName = $_ENV['DB_USERNAME'];
        $password = $_ENV['DB_PASSWORD'];

        $dsn = "mysql:host={$host};dbname={$dbname}";

        return new PDO(
            $dsn,
            $userName,
            $password,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );
    }
}
