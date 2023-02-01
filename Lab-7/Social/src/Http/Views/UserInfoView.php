<?php

declare(strict_types=1);

namespace Social\Http\Views;


use Social\Http\ViewModels\UserInfoViewModel;

class UserInfoView extends View
{
    public function __construct(UserInfoViewModel $model)
    {
        parent::__construct($model, 'user-info');
    }
}