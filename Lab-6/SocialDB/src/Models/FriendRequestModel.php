<?php

declare(strict_types=1);

namespace SocialDB\Models;

class FriendRequestModel
{
    public int $id;
    public int $toUserId;
    public int $fromUserId;
    public int $status;
    public string $sendDate;
}
