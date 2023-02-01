<?php


namespace Social\Models;


class PostModel
{
    public int $id;
    public int $authorId;
    public string $sendDate;
    public string $text;
    /**
     * @var int[] $likes
     */
    public array $likes;
}
