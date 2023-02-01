<?php

declare(strict_types=1);

use WebMusicViewer\DataAccess\AlbumRepository;
use WebMusicViewer\DataAccess\PdoFactory;

require_once __DIR__ . '/../bootstrap.php';

$pdo = PdoFactory::createFromEnv();
$albumRepository = new AlbumRepository($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $albumName = $_POST['title'];

    $albumRepository->insert($albumName);

    header('Location: albums.php', true, 303);
    exit();
}

