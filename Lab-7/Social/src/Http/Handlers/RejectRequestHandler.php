<?php


namespace Social\Http\Handlers;


use Social\AuthorizationService;
use Social\DataAccess\FriendRequestRepository;
use Social\DataAccess\PdoFactory;
use Social\Http\Views\RequestRejectedView;

class RejectRequestHandler implements IHttpRequestHandler
{
    private FriendRequestRepository $friendRequestRepository;

    public function __construct()
    {
        $pdo = PdoFactory::createFromEnv();
        $this->friendRequestRepository = new FriendRequestRepository($pdo);
    }

    public function handle(array $requestData): RequestRejectedView
    {
        session_start();
        AuthorizationService::checkUserIsAuthorized();

        $id = AuthorizationService::getUserId();

        $this->friendRequestRepository->rejectRequest($id, (int)$requestData['userFromId']);
        return new RequestRejectedView();
    }
}