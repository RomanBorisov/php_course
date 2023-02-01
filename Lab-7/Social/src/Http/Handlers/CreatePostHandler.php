<?php

declare(strict_types=1);

namespace Social\Http\Handlers;

use Social\AuthorizationService;
use Social\DataAccess\PdoFactory;
use Social\DataAccess\PostRepository;
use Social\Http\ViewModels\PostCreatedViewModel;
use Social\Http\Views\PostCreatedView;


class CreatePostHandler implements IHttpRequestHandler
{
    private PostRepository $postRepository;

    public function __construct()
    {
        $pdo = PdoFactory::createFromEnv();
        $this->postRepository = new PostRepository($pdo);
    }

    public function handle(array $requestData): PostCreatedView
    {
        session_start();
        AuthorizationService::checkUserIsAuthorized();

        $authorId = AuthorizationService::getUserId();
        $this->postRepository->create($authorId, $requestData['message']);

        return new PostCreatedView(new PostCreatedViewModel(AuthorizationService::getUserName()));
    }
}