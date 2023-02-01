<?php

declare(strict_types=1);

namespace Social\Models;


class LikeModel
{
    public int $id;
    public int $userId;
    public int $postId;
}
