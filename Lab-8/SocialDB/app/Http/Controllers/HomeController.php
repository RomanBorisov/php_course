<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Factory;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * @var Factory
     */
    public $authFactory;

    /**
     * Create a new controller instance.
     *
     * @param Factory $factory
     */
    public function __construct(Factory $factory)
    {
        $this->authFactory = $factory->guard();
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index(): Renderable
    {
        return view('home', ['username' => $this->authFactory->user()->name]);
    }
}
