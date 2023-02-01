<?php

namespace App\Http\Controllers;

use App\DAO\PostDAO;
use App\DBModels\Post;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * @var PostDAO
     */
    public $postDAO;
    /**
     * @var Factory
     */
    public $authFactory;

    public function __construct(PostDAO $postDAO, Factory $factory)
    {
        $this->postDAO = $postDAO;
        $this->authFactory = $factory->guard();
    }

    /**
     * @return Application|\Illuminate\Contracts\View\Factory|View
     */
    public function myPosts()
    {
        $posts = $this->postDAO->getUserPosts($this->authFactory->user());
        return view('posts.posts-list', ['posts' => $posts]);
    }

    public function index()
    {
        $posts = Post::latest()->with(['user', 'likes'])->paginate(20);

        return view('posts.index', [
            'posts' => $posts
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'text' => 'required'
        ]);

        $this->postDAO->createPost($this->authFactory->id(), $request->text);

        return back()->withSuccess('Post successfully created');
    }

    /**
     * @param Post $post
     * @return RedirectResponse
     */
    public function destroy(Post $post): RedirectResponse
    {
        $this->authorize('delete', $post);
        $this->postDAO->deletePost($post);

        return back();
    }
}
