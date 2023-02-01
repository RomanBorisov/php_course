<?php

declare(strict_types=1);

namespace Social\Http\Views;


use Social\Http\ViewModels\AuthorizationViewModel;

class AuthorizationView extends View
{
    public function __construct(?AuthorizationViewModel $model = null)
    {
        parent::__construct($model, 'authorization');
    }
}