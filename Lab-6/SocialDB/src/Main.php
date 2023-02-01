#!/usr/bin/env php
<?php
// application.php
declare(strict_types=1);

require '../vendor/autoload.php';

use SocialDB\Commands\CancelFriendRequest;
use SocialDB\Commands\CreatePost;
use SocialDB\Commands\DeclineFriendRequest;
use SocialDB\Commands\GenerateUsers;
use SocialDB\Commands\GetUserInfo;
use SocialDB\Commands\ImportToDB;
use SocialDB\Commands\LikePost;
use SocialDB\Commands\RemovePost;
use SocialDB\Commands\SendFriendRequest;
use SocialDB\Commands\UnlikePost;
use Symfony\Component\Console\Application;

$application = new Application();

$pdo = new PDO(
    'mysql:host=localhost;dbname=social',
    'root',
    'root',
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
);


$application->addCommands(
    [
        new GenerateUsers(),
        new ImportToDB($pdo),
        new GetUserInfo($pdo),
        new LikePost($pdo),
        new UnlikePost($pdo),
        new CreatePost($pdo),
        new RemovePost($pdo),
        new SendFriendRequest($pdo),
        new CancelFriendRequest($pdo),
        new DeclineFriendRequest($pdo),
    ]
);

$application->run();
