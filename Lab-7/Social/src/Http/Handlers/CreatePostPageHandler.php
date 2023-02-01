<?php

declare(strict_types=1);

namespace Social\Http\Handlers;

use Social\AuthorizationService;
use Social\Http\Views\CreatePostView;

class CreatePostPageHandler implements IHttpRequestHandler
{
    public function handle(array $requestData): CreatePostView
    {
        session_start();
        AuthorizationService::checkUserIsAuthorized();

        return new CreatePostView();
    }
}