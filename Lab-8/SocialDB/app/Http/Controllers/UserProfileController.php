<?php

namespace App\Http\Controllers;

use App\DAO\PostDAO;
use App\DAO\UserDAO;
use App\DBModels\User;
use App\Services\FriendsService;

class UserProfileController extends Controller
{
    /**
     * @var UserDAO
     */
    public $userDAO;

    /**
     * @var FriendsService
     */
    public $friendsService;

    public $postDAO;

    public function __construct(UserDAO $userDAO, FriendsService $friendsService, PostDAO $postDAO)
    {
        $this->userDAO = $userDAO;
        $this->friendsService = $friendsService;
        $this->postDAO = $postDAO;
    }

    public function index(User $user)
    {
        $friends = $this->friendsService->getFriends($user->id);
        $posts = $this->postDAO->getUserPostsWithLikes($user);

        return view('user.user-profile', [
            'user' => $user,
            'posts' => $posts,
            'friends' => $friends
        ]);
    }
}
