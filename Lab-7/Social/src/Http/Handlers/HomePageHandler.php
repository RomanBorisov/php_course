<?php

declare(strict_types=1);

namespace Social\Http\Handlers;


use Social\AuthorizationService;
use Social\Http\Views\HomePageView;
use Social\Http\ViewModels\HomePageViewModel;

class HomePageHandler implements IHttpRequestHandler
{

    public function handle(array $requestData): HomePageView
    {
        session_start();
        return new HomePageView(new HomePageViewModel(AuthorizationService::isAuthorized()));
    }
}
