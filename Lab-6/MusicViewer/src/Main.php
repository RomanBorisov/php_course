<?php

declare(strict_types=1);

require '../vendor/autoload.php';

use MusicViewer\Commands\AddAlbumCommand;
use MusicViewer\Commands\AddSongCommand;
use MusicViewer\Commands\ListAlbumsCommand;
use MusicViewer\Commands\ListAlbumSongsCommand;
use MusicViewer\Commands\RemoveAlbumCommand;
use MusicViewer\Commands\RemoveSongCommand;
use MusicViewer\Commands\ShowAlbumDurationCommand;
use Symfony\Component\Console\Application;

$application = new Application();

$pdo =  new PDO(
    'mysql:host=localhost;dbname=music',
    'root',
    'root',
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
);

$application->addCommands(
    [
        new AddAlbumCommand($pdo),
        new AddSongCommand($pdo),
        new ListAlbumsCommand($pdo),
        new ListAlbumSongsCommand($pdo),
        new RemoveSongCommand($pdo),
        new RemoveAlbumCommand($pdo),
        new ShowAlbumDurationCommand($pdo),
    ]
);

$application->run();
