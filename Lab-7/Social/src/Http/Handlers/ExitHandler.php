<?php

declare(strict_types=1);

namespace Social\Http\Handlers;


use Social\AuthorizationService;
use Social\DataAccess\PdoFactory;
use Social\DataAccess\UserRepository;
use Social\Http\Views\ExitPageView;

class ExitHandler implements IHttpRequestHandler
{
    public UserRepository $userRepository;

    public function __construct()
    {
        $pdo = PdoFactory::createFromEnv();
        $this->userRepository = new UserRepository($pdo);
    }

    public function handle(array $requestData): ExitPageView
    {
        session_start();
        AuthorizationService::checkUserIsAuthorized();
        AuthorizationService::exit();

        return new ExitPageView();
    }
}