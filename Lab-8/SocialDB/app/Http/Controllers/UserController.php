<?php

namespace App\Http\Controllers;

use App\DAO\UserDAO;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class UserController extends Controller
{
    /**
     * @var UserDAO
     */
    public $userDAO;

    public function __construct(UserDAO $userDAO)
    {
        $this->userDAO = $userDAO;
    }

    /**
     * @return Application|Factory|View
     */
    public function getAll()
    {
        $users = $this->userDAO->getAll();
        return view('users.users-list', ['users' => $users]);
    }
}
