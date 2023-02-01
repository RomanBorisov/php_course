<?php

declare(strict_types=1);

namespace Social\Http\Views;


use Social\Http\ViewModels\UserPostsViewModel;

class ListUserPostsView extends View
{
    public function __construct(UserPostsViewModel $model)
    {
        parent::__construct($model, 'list-user-posts');
    }
}