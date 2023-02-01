<?php

declare(strict_types=1);

namespace Social\Http\Handlers;


use Social\AuthorizationService;
use Social\DataAccess\FriendRequestRepository;
use Social\DataAccess\PdoFactory;
use Social\Http\ViewModels\ListFriendRequestsViewModel;
use Social\Http\Views\ListSentFriendRequestView;

class ListSentFriendRequestsPageHandler implements IHttpRequestHandler
{
    private FriendRequestRepository $friendRequestRepository;

    public function __construct()
    {
        $pdo = PdoFactory::createFromEnv();
        $this->friendRequestRepository = new FriendRequestRepository($pdo);
    }

    public function handle(array $requestData): ListSentFriendRequestView
    {
        session_start();
        AuthorizationService::checkUserIsAuthorized();

        $id = AuthorizationService::getUserId();

        $requests = $this->friendRequestRepository->getRequestsSendFromUser($id);
        return new ListSentFriendRequestView(new ListFriendRequestsViewModel($requests));
    }
}