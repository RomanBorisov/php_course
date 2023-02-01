<?php

declare(strict_types=1);

use WebMusicViewer\DataAccess\AlbumRepository;
use WebMusicViewer\DataAccess\PdoFactory;

require_once __DIR__ . '/../bootstrap.php';

$pdo = PdoFactory::createFromEnv();
$albumRepository = new AlbumRepository($pdo);

$albums = $albumRepository->getAll();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Albums</title>
</head>
<body>
<form name="create-album" method="POST" action="create-album.php">
    <label>Title: <input type="text" name="title"></label>
    <input type="submit" value="Create">
</form>
<h4>Albums:</h4>
<ul>
    <?php
    foreach ($albums as $album) {
        $date = $album->date ?? 'None';
        ?>
        <li>
            Id: <strong><?php echo $album->id; ?></strong>,
            Title: <strong><?php echo $album->title; ?></strong>,
            Date: <strong><?php echo $date; ?></strong>
            <a href="album.php?id=<?php echo $album->id; ?>&title=<?php echo $album->title; ?>">Show songs</a>
            <a href="remove-album.php?id=<?php echo $album->id; ?>&title=<?php echo $album->title; ?>">Remove</a>
        </li>
    <?php } ?>
</ul>
</body>
</html>
