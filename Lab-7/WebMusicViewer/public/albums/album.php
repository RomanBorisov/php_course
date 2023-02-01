<?php

declare(strict_types=1);

use WebMusicViewer\DataAccess\AlbumRepository;
use WebMusicViewer\DataAccess\PdoFactory;
use WebMusicViewer\DataAccess\SongRepository;
use WebMusicViewer\Models\Song;

require_once __DIR__ . '/../bootstrap.php';

$pdo = PdoFactory::createFromEnv();
$songRepository = new SongRepository($pdo);
$albumRepository = new AlbumRepository($pdo);

$albumId = (int)$_GET['id'];
$albumName = $_GET['title'];

$songs = $songRepository->getByAlbumId($albumId);
$isExist = $albumRepository->getById($albumId) !== null;

$songDuration = songsSummaryDuration($songs);

/**
 * @param Song[] $songs
 */
function songsSummaryDuration(array $songs): array
{
    $hours = 0;
    $minutes = 0;
    $seconds = 0;

    foreach ($songs as $song) {
        $songDuration = explode(':', $song->duration);

        $hours += (int)$songDuration[0];
        $minutes += (int)$songDuration[1];
        $seconds += (int)$songDuration[2];
    }

    if ($seconds >= 60) {
        $minutes += $seconds / 60;
    }
    if ($minutes >= 60) {
        $hours += $minutes / 60;
    }

    $minutes %= 60;
    $seconds %= 60;

    return ['hours' => $hours, 'minutes' => $minutes, 'seconds' => $seconds];
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Album</title>
</head>
<body>
<a href="add-song.php?id=<?php echo $albumId; ?>">Add song</a>
<h4>Album: <?php echo $albumName; ?></h4>
<?php if ($isExist) { ?>
<h5>Summary
    duration: <?php echo $songDuration['hours'] . ":" . $songDuration['minutes'] . ":" . $songDuration['seconds']; ?></h5>
<ul>
    <?php
    foreach ($songs as $song) {
        ?>
        <li>
            Id: <strong><?php echo $song->id; ?></strong>,
            Title: <strong><?php echo $song->title; ?></strong>,
            Duration: <strong><?php echo $song->duration; ?></strong>
            <a href="remove-song.php?id=<?php echo $song->id; ?>&title=<?php echo $song->title; ?>&album_id=<?php echo $albumId; ?>&album_name=<?php echo $albumName; ?>">Remove</a>
        </li>
    <?php }
    } ?>
</ul>
</body>
</html>
