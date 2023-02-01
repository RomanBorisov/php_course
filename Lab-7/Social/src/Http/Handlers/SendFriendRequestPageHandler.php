<?php

declare(strict_types=1);

namespace Social\Http\Handlers;


use Social\AuthorizationService;
use Social\DataAccess\FriendRequestRepository;
use Social\DataAccess\PdoFactory;
use Social\DataAccess\UserRepository;
use Social\Http\ViewModels\RequestSentViewModel;
use Social\Http\Views\RequestSentView;

class SendFriendRequestPageHandler implements IHttpRequestHandler
{
    private FriendRequestRepository $friendRequestRepository;
    private UserRepository $userRepository;

    public function __construct()
    {
        $pdo = PdoFactory::createFromEnv();
        $this->friendRequestRepository = new FriendRequestRepository($pdo);
        $this->userRepository = new UserRepository($pdo);
    }

    public function handle(array $requestData): RequestSentView
    {
        session_start();
        AuthorizationService::checkUserIsAuthorized();

        $user = AuthorizationService::getUserId();

        $toUser = $this->userRepository->getIdByName($requestData['name']);

        if ($toUser !== null) {
            if (!$this->friendRequestRepository->checkRequestExist($user, $toUser)) {
                $this->friendRequestRepository->sendRequest($user, $toUser);

                return new RequestSentView(new RequestSentViewModel($requestData['name']));
            }

            return new RequestSentView(new RequestSentViewModel($requestData['name'], 'Request already sent'));
        }

        return new RequestSentView(
            new RequestSentViewModel($requestData['name'], "User - {$requestData['name']}, not found!")
        );
    }
}