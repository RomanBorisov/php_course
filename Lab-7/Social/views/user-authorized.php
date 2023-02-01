<?php

declare(strict_types=1);

/** @var Social\Http\ViewModels\AuthorizedViewModel $model */

use Social\AuthorizationService;

?>
<html lang="en">
<head>
    <title>Home page</title>
    <style>
        li {
            list-style-type: none;
            text-underline: none;
        }
    </style>
</head>
<?php
if (AuthorizationService::isAuthorized()) {
    ?>
    <h3> Hello <?php echo $model->name; ?></h3>
    <ul>
        <li><a href="/user-info">User info</a></li>
        <li><a href="/create-post">Create post</a></li>
        <li><a href="/list-user-posts">Show posts</a></li>
        <li><a href="/list-sent-friend-requests">Sent friendship requests</a></li>
        <li><a href="/list-received-friend-requests">Received friendship requests</a></li>
        <li><a href="/send-friend-request">Send friend request</a></li>
        <li><a href="/exit">Exit</a></li>
    </ul>

    <?php
} else { ?>
    <h3><?php
        echo $model->message; ?></h3>
    <a href="authorization">authorization</a>
    <?php
} ?>

</html>
