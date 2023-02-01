<?php

declare(strict_types=1);

namespace SocialDB\Models;

class PostModel
{
    public int $authorId;
    /**
     * @var int[] $likes
     */
    public array $likes;
    public int $id;
    public string $sendDate;
    public string $text;

}
