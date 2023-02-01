<?php

declare(strict_types=1);

/** @var Social\Http\ViewModels\ListFriendRequestsViewModel $model */

?>
<html lang="en">
<head>
    <title>Sent requests</title>
</head>
<body>
<a href="/">Home page</a>

<h3>Send friend requests:</h3>
<ul>
    <?php
    foreach ($model->requests as $request) {
        ?>
        <li>
            User To Id:<strong><?php
                echo $request->toUserId; ?></strong>,
            Status:<strong> <?php
                echo $request->status; ?> </strong>,
            <strong><a href="/cancel-request?userToId=<?php
                echo $request->toUserId; ?>">Cancel</a></strong>
        </li>
        <?php
    } ?>
</ul>
</body>
</html>
