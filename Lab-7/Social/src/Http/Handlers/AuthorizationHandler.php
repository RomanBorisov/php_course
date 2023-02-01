<?php

declare(strict_types=1);

namespace Social\Http\Handlers;

use Social\AuthorizationService;
use Social\DataAccess\PdoFactory;
use Social\DataAccess\UserRepository;
use Social\Http\ViewModels\AuthorizedViewModel;
use Social\Http\Views\HomePageView;
use Social\Http\Views\UserAuthorizedView;

class AuthorizationHandler implements IHttpRequestHandler
{

    public UserRepository $userRepository;

    public function __construct()
    {
        $pdo = PdoFactory::createFromEnv();
        $this->userRepository = new UserRepository($pdo);
    }

    public function handle(array $requestData): UserAuthorizedView
    {
        $name = $requestData['name'];
        $password = $requestData['password'];

        $authorization = new AuthorizationService();

        try {
            $authorization->authorize($name, $password);

            $authorizedViewModel = new AuthorizedViewModel(
                AuthorizationService::getUserName(),
                AuthorizationService::getUserId()
            );

            $view = new UserAuthorizedView($authorizedViewModel);
            $view->render();
        } catch (\Exception $e) {
            $authorizedViewModel = new AuthorizedViewModel(
                $name,
                AuthorizationService::getUserId(),
                $e->getMessage()
            );

            return new UserAuthorizedView($authorizedViewModel);
        }
    }
}
