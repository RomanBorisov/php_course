<?php

declare(strict_types=1);

/** @var Social\Http\ViewModels\UserInfoViewModel $model */

?>
<html lang="en">
<head>
    <title>User info</title>
    <style>
        li {
            list-style: none;
        }
    </style>
</head>
<body>
<a href="/">Home page</a>

<h1>Hello <?php echo $model->name ?></h1>
<h4>Friends: <?php echo count($model->friends) ?></h4>
<ul>
    <?php
    foreach ($model->friends as $user) {
        ?>
        <li>
            Name:
            <strong>
                <?php echo $user->name; ?>
            </strong>
        </li>
        <?php
    } ?>
</ul>

<h4>Friends is online: <?php echo count($model->friendsIsOnline) ?></h4>
<ul>
    <?php
    foreach ($model->friendsIsOnline as $user) {
        ?>
        <li>
            Name:
            <strong>
                <?php echo $user->name; ?>
            </strong>
        </li>
        <?php
    } ?>
</ul>

<h4>Subscribers: <?php echo count($model->subscribers) ?></h4>
<ul>
    <?php
    foreach ($model->subscribers as $subscriber) {
        ?>
        <li>
            Name:
            <strong>
                <?php echo $subscriber->name; ?>
            </strong>
        </li>
        <?php
    } ?>
</ul>

<h4>New friendship requests: <?php echo count($model->newFriendRequests) ?></h4>
<ul>
    <?php
    foreach ($model->newFriendRequests as $request) {
        ?>
        <li>
            Sender:<strong><?php
                echo $request->fromUserId; ?></strong>,
            Status:<strong> <?php
                echo $request->status; ?> </strong>,
            <strong><a href="/reject-request?userFromId=<?php
                echo $request->fromUserId; ?>">Reject</a></strong>
        </li>
        <?php
    } ?>
</ul>

<h4>News:
    <?php
    if (count($model->newsFeed) === 0) {
        echo "There are no news for you";
    } ?></h4>
<ul><?php
    foreach ($model->newsFeed as $post) {
        ?>
        <li>
            Text: <strong><?php echo $post->text; ?></strong>
            <br>
            Likes: <strong><?php echo $post->numberLikes ?></strong>
            <a href="/like-post?postId=<?php echo $post->id; ?>">Like</a>
        </li>
        <?php
    } ?>
</ul>

</body>
</html>

