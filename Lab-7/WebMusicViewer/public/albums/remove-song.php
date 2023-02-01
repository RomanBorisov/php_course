<?php

declare(strict_types=1);

use WebMusicViewer\DataAccess\PdoFactory;
use WebMusicViewer\DataAccess\SongRepository;

require_once __DIR__ . '/../bootstrap.php';

$pdo = PdoFactory::createFromEnv();
$songRepository = new SongRepository($pdo);

$songId = (int)$_GET['id'];
$songName = $_GET['title'];
$albumId = $_GET['album_id'];
$albumName = $_GET['album_name'];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Remove song</title>
</head>
<body>
    <button onclick="<?php $songRepository->remove($songId);
    header('Location: album.php?id=' . $albumId . '&title=' . $albumName, true, 303);
    exit(); ?>">Yes
    </button>
</body>
</html>
