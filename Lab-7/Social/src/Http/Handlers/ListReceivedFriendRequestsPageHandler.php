<?php

declare(strict_types=1);

namespace Social\Http\Handlers;


use Social\AuthorizationService;
use Social\DataAccess\FriendRequestRepository;
use Social\DataAccess\PdoFactory;
use Social\Http\ViewModels\ListFriendRequestsViewModel;
use Social\Http\Views\ListReceivedFriendRequestsView;

class ListReceivedFriendRequestsPageHandler implements IHttpRequestHandler
{
    private FriendRequestRepository $friendRequestRepository;

    public function __construct()
    {
        $pdo = PdoFactory::createFromEnv();
        $this->friendRequestRepository = new FriendRequestRepository($pdo);
    }

    public function handle(array $requestData): ListReceivedFriendRequestsView
    {
        session_start();
        AuthorizationService::checkUserIsAuthorized();

        $id = AuthorizationService::getUserId();
        $request = new ListFriendRequestsViewModel($this->friendRequestRepository->getRequestsSendToUser($id));
        return new ListReceivedFriendRequestsView($request);
    }
}