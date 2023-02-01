<?php
declare(strict_types=1);

namespace Social\Models;


class FriendRequestModel
{
    public int $fromUserId;
    public int $toUserId;
    public int $status;
    public string $sendDate;
}
