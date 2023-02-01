<?php

declare(strict_types=1);

namespace Social\Http\ViewModels;


class UserPostsViewModel
{
    /** @var PostViewModel[] $posts*/
    public array $posts;

    /**
     * @param PostViewModel[] $posts
     */
    public function __construct(array $posts)
    {
        $this->posts = $posts;
    }
}