<?php

declare(strict_types=1);

/** @var Social\Http\ViewModels\ListFriendRequestsViewModel $model */

?>
<html lang="en">
<head>
    <title>Received requests</title>
</head>
<body>
<a href="/">Home page</a>

<h3>Friendship requests received:</h3>
<ul>
    <?php
    foreach ($model->requests as $request) {
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
</body>
</html>
