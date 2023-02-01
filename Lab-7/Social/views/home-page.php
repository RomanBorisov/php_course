<?php

declare(strict_types=1);

/** @var Social\Http\ViewModels\HomePageViewModel $model */

?>
<html lang="en">
<head>
    <title>Home page</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
        }

        .link {
            margin: 5px;
        }

        .exit {
            border-top: 1px solid black;
            margin-top: 20px;
            padding-top: 5px;
        }

    </style>
</head>
<body>
<?php if ($model->isAuthorized) { ?>
    <a class="link" href="/user-info">User info</a>
    <a class="link" href="/create-post">Create post</a>
    <a class="link" href="/list-user-posts">Show posts</a>
    <a class="link" href="/list-sent-friend-requests">Sent friendship requests</a>
    <a class="link" href="/list-received-friend-requests">Received friendship requests</a>
    <a class="link" href="/send-friend-request">Send friend request</a>
    <a class="link exit" href="/exit">Exit</a>
    <?php
} else {
    echo '<a href="/authorization">Sign In</a>';
}
?>
</body>
</html>
