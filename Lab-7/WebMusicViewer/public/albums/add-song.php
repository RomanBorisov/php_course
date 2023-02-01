<?php

declare(strict_types=1);

use WebMusicViewer\DataAccess\PdoFactory;
use WebMusicViewer\DataAccess\SongRepository;

require_once __DIR__ . '/../bootstrap.php';

$pdo = PdoFactory::createFromEnv();
$songRepository = new SongRepository($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $songName = $_POST['title'];
    $albumId = (int)$_POST['album-id'];
    $hours = $_POST['h'];
    $minutes = $_POST['m'];
    $seconds = $_POST['s'];

    $songRepository->insert($songName, $hours . ':' . $minutes . ':' . $seconds, $albumId);

    header("Location: album.php?id=" . $albumId.'&title=', true, 303);
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add song</title>
</head>
<body>
<form name="add-song" method="POST" action="add-song.php">
    <label>Title: <input type="text" name="title"></label>
    <label>Album id: <input type="text" name="album-id" value="<?php echo   $_GET['id'];?>"></label>
    <br>
    Duration:
    <input id='h' name='h' type='number' min='0' max='24'>
    <label for='h'>h</label>
    <input id='m' name='m' type='number' min='0' max='59'>
    <label for='m'>m</label>
    <input id='s' name='s' type='number' min='0' max='59'>
    <label for='s'>s</label>
    <br>
    <input type="submit" value="Create">
</form>
</body>
</html>
