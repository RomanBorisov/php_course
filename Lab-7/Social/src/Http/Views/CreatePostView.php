<?php

declare(strict_types=1);

namespace Social\Http\Views;

class CreatePostView extends View
{
    public function __construct()
    {
        parent::__construct(null, 'create-post');
    }
}