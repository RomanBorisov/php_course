<?php

namespace App\Http\Controllers;

use App\DAO\LikeDAO;
use App\DBModels\Post;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Http\RedirectResponse;

class PostLikeController extends Controller
{
    /**
     * @var LikeDAO
     */
    public $likeDAO;
    /**
     * @var Factory
     */
    public $authFactory;

    public function __construct(LikeDAO $likeDAO, Factory $factory)
    {
        $this->likeDAO = $likeDAO;
        $this->authFactory = $factory->guard();
    }

    public function store(Post $post): RedirectResponse
    {
        $this->likeDAO->addLikeToPostByUser($post, $this->authFactory->id());

        return back();
    }


    public function destroy(Post $post): RedirectResponse
    {
        $this->likeDAO->removeLikeToPostByUser($post, $this->authFactory->id());

        return back();
    }
}
