<?php

declare(strict_types=1);

namespace Social\Http\Handlers;


use Social\AuthorizationService;
use Social\DataAccess\PdoFactory;
use Social\DataAccess\PostRepository;
use Social\Http\Views\PostRemovedView;

class RemovePostHandler implements IHttpRequestHandler
{
    private PostRepository $postRepository;

    public function __construct()
    {
        $pdo = PdoFactory::createFromEnv();
        $this->postRepository = new PostRepository($pdo);
    }

    public function handle(array $requestData): PostRemovedView
    {
        session_start();
        AuthorizationService::checkUserIsAuthorized();

        $postId = (int)$requestData['postId'];
        $this->postRepository->removePost($postId);

        return new PostRemovedView();
    }
}