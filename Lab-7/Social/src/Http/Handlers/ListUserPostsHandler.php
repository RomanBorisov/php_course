<?php

declare(strict_types=1);

namespace Social\Http\Handlers;

use Social\AuthorizationService;
use Social\DataAccess\LikesRepository;
use Social\DataAccess\PdoFactory;
use Social\DataAccess\PostRepository;
use Social\Http\ViewModels\UserPostsViewModel;
use Social\Http\Views\ListUserPostsView;

class ListUserPostsHandler implements IHttpRequestHandler
{
    public PostRepository $postRepository;
    public LikesRepository $likeRepository;

    public function __construct()
    {
        $pdo = PdoFactory::createFromEnv();
        $this->postRepository = new PostRepository($pdo);
        $this->likeRepository = new LikesRepository($pdo);
    }

    public function handle(array $requestData): ListUserPostsView
    {
        session_start();
        AuthorizationService::checkUserIsAuthorized();

        $id = AuthorizationService::getUserId();

        $userPosts = $this->postRepository->getListPostsByUserIds([$id]);

        return new ListUserPostsView(new UserPostsViewModel($userPosts));
    }
}
