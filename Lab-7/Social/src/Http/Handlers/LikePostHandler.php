<?php

declare(strict_types=1);

namespace Social\Http\Handlers;

use Social\AuthorizationService;
use Social\DataAccess\LikesRepository;
use Social\DataAccess\PdoFactory;
use Social\DataAccess\PostRepository;
use Social\Http\Views\LikePostView;


class LikePostHandler implements IHttpRequestHandler
{
    public PostRepository $postRepository;
    public LikesRepository $likeRepository;

    public function __construct()
    {
        $pdo = PdoFactory::createFromEnv();
        $this->postRepository = new PostRepository($pdo);
        $this->likeRepository = new LikesRepository($pdo);
    }

    public function handle(array $requestData): LikePostView
    {
        session_start();
        AuthorizationService::checkUserIsAuthorized();

        $id = AuthorizationService::getUserId();

        $postId = (int)$requestData['postId'];

        if (!$this->likeRepository->checkExistLike($id, $postId)) {
            $this->likeRepository->likePost($id, $postId);
            return new LikePostView();
        }

        $this->likeRepository->removeLike($id, $postId);
        return new LikePostView();
    }
}
