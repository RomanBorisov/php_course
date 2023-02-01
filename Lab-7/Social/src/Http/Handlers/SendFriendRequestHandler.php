<?php

declare(strict_types=1);

namespace Social\Http\Handlers;

use Social\AuthorizationService;
use Social\Http\Views\SendRequestView;

class SendFriendRequestHandler implements IHttpRequestHandler
{

    public function handle(array $requestData): SendRequestView
    {
        session_start();
        AuthorizationService::checkUserIsAuthorized();

        return new SendRequestView();
    }
}