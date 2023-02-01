<?php

declare(strict_types=1);

namespace Social\Http\Handlers;


use Social\AuthorizationService;
use Social\DataAccess\FriendRequestRepository;
use Social\DataAccess\LikesRepository;
use Social\DataAccess\PdoFactory;
use Social\DataAccess\PostRepository;
use Social\DataAccess\UserRepository;
use Social\Http\ViewModels\PostViewModel;
use Social\Http\ViewModels\UserInfoViewModel;
use Social\Http\Views\UserInfoView;
use Social\Models\UserModel;
use Social\Services\FriendsService;
use Social\Services\SubscribersService;

class UserInfoHandler implements IHttpRequestHandler
{
    public UserRepository $userRepository;
    public PostRepository $postRepository;
    public LikesRepository $likeRepository;
    public FriendRequestRepository $friendRequestRepository;

    public FriendsService $friendsService;
    public SubscribersService $subscribersService;

    public function __construct()
    {
        $pdo = PdoFactory::createFromEnv();

        $this->friendsService = new FriendsService($pdo);
        $this->subscribersService = new SubscribersService($pdo);

        $this->userRepository = new UserRepository($pdo);
        $this->postRepository = new PostRepository($pdo);
        $this->likeRepository = new LikesRepository($pdo);
        $this->friendRequestRepository = new FriendRequestRepository($pdo);
    }

    public function handle(array $requestData): UserInfoView
    {
        session_start();
        AuthorizationService::checkUserIsAuthorized();

        $id = AuthorizationService::getUserId();

        $user = $this->userRepository->getUserById($id);

        $friends = $this->friendsService->getFriends($user);

        $friendsIsOnline = array_filter($friends, fn(UserModel $friend): bool => $friend->online === true);

        $subscribers = $this->subscribersService->getSubscribers($user);

        $newRequests = $this->friendRequestRepository->getListNewFriendRequests($id);

        $friendIds = array_map(fn(UserModel $user) => $user->id, $friends);
        $friendPosts = $this->postRepository->getListPostsByUserIds(array_values($friendIds));
        $newsFeed = array_filter(
            $friendPosts,
            fn(PostViewModel $post): bool => strtotime($post->sendDate) > strtotime(
                    $this->userRepository->getUserById($id)->lastVisit
                )
        );

        return new UserInfoView(new UserInfoViewModel($user->name, $friends, $friendsIsOnline, $subscribers, $newRequests, $newsFeed));
    }

}
