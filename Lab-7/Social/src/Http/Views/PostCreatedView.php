<?php

declare(strict_types=1);

namespace Social\Http\Views;

use Social\Http\ViewModels\PostCreatedViewModel;

class PostCreatedView extends View
{
    public function __construct(PostCreatedViewModel $model)
    {
        parent::__construct($model, 'post-created');
    }
}