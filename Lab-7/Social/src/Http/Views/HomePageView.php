<?php

declare(strict_types=1);

namespace Social\Http\Views;


use Social\Http\ViewModels\HomePageViewModel;

class HomePageView extends View
{
    public function __construct(HomePageViewModel $model)
    {
        parent::__construct($model, 'home-page');
    }
}
