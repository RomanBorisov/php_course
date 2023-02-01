<?php

$rootDir = __DIR__ . '/..';
require_once "{$rootDir}/vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable($rootDir);
$dotenv->load();
