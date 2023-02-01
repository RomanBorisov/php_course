<?php

declare(strict_types=1);

namespace Social\Http\Handlers;

use Social\AuthorizationService;
use Social\DataAccess\FriendRequestRepository;
use Social\DataAccess\PdoFactory;
use Social\Http\Views\RequestCanceledView;

class CancelRequestHandler implements IHttpRequestHandler
{
    private FriendRequestRepository $friendRequestRepository;

    public function __construct()
    {
        $pdo = PdoFactory::createFromEnv();
        $this->friendRequestRepository = new FriendRequestRepository($pdo);
    }

    public function handle(array $requestData): RequestCanceledView
    {
        session_start();
        AuthorizationService::checkUserIsAuthorized();

        $id = AuthorizationService::getUserId();

        $this->friendRequestRepository->cancelRequest($id, (int)$requestData['userToId']);

        return new RequestCanceledView();
    }
}