<?php

    declare(strict_types=1);

    use WebMusicViewer\DataAccess\AlbumRepository;
    use WebMusicViewer\DataAccess\PdoFactory;

    require_once __DIR__ . '/../bootstrap.php';

    $pdo = PdoFactory::createFromEnv();
    $albumRepository = new AlbumRepository($pdo);

    $albumId = (int)$_GET['id'];
    $albumName = $_GET['title'];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Remove album</title>
</head>
<body>
    <h4>Are you sure you want to delete album '<?php echo $albumName; ?>'?</h4>
    <button onclick="<?php $albumRepository->remove($albumId);header('Location: albums.php', true, 303);exit(); ?>">Yes</button>
    <button onclick="header('Location: albums.php', true, 303);exit();">No</button>
</body>
</html>>
