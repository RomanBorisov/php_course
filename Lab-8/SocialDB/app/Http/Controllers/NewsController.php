<?php

namespace App\Http\Controllers;

use App\DAO\PostDAO;
use App\Services\FriendsService;
use Illuminate\Contracts\Auth\Factory;

class NewsController extends Controller
{
    /**
     * @var FriendsService
     */
    public $friendsService;
    /**
     * @var Factory
     */
    public $authFactory;
    /**
     * @var PostDAO
     */
    public $postDAO;

    public function __construct(FriendsService $friendsService, Factory $factory, PostDAO $postDAO)
    {
        $this->friendsService = $friendsService;
        $this->authFactory = $factory->guard();
        $this->postDAO = $postDAO;
    }

    public function index()
    {
        $currentUser = $this->authFactory->user();
        $lastVisit = $currentUser->last_visit;
        $friends = $this->friendsService->getFriends($currentUser->id);

        $friendsPosts = $friends
            ->map(
                function ($friend) {
                    return $this->postDAO->getUserPostsWithLikes($friend);
                })
            ->collapse()
            ->filter(
                function ($post) use ($lastVisit) {
                    return $post->created_at > $lastVisit;
                });

        return view('news.news-list', [
            'posts' => $friendsPosts
        ]);
    }

}
