<?php

declare(strict_types=1);

namespace Social\Http\Handlers;


use Social\AuthorizationService;
use Social\Http\ViewModels\AuthorizationViewModel;
use Social\Http\Views\AuthorizationView;

class AuthorizationPageHandler implements IHttpRequestHandler
{

    public function handle(array $requestData): AuthorizationView
    {
        session_start();
        if (AuthorizationService::isAuthorized()) {
            return new AuthorizationView(new AuthorizationViewModel('You are already logged in'));
        }

        return new AuthorizationView();
    }
}
