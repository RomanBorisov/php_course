<?php

declare(strict_types=1);

namespace Social\Http\ViewModels;


class PostViewModel
{
    public int $id;
    public int $authorId;
    public string $sendDate;
    public string $text;
    public int $numberLikes;
}