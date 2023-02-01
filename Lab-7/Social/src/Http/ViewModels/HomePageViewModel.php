<?php

declare(strict_types=1);

namespace Social\Http\ViewModels;


class HomePageViewModel
{
    public bool $isAuthorized;

    public function __construct(bool $isAuthorized)
    {
        $this->isAuthorized = $isAuthorized;
    }
}
