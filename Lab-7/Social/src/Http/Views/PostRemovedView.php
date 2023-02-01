<?php

declare(strict_types=1);

namespace Social\Http\Views;


class PostRemovedView extends View
{
    public function __construct()
    {
        parent::__construct(null, 'post-removed');
    }
}