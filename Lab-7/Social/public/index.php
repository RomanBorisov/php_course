<?php

declare(strict_types=1);

use Social\Http\Handlers\AuthorizationHandler;
use Social\Http\Handlers\AuthorizationPageHandler;
use Social\Http\Handlers\CancelRequestHandler;
use Social\Http\Handlers\CreatePostHandler;
use Social\Http\Handlers\CreatePostPageHandler;
use Social\Http\Handlers\ExitHandler;
use Social\Http\Handlers\HomePageHandler;
use Social\Http\Handlers\LikePostHandler;
use Social\Http\Handlers\ListReceivedFriendRequestsPageHandler;
use Social\Http\Handlers\ListSentFriendRequestsPageHandler;
use Social\Http\Handlers\ListUserPostsHandler;
use Social\Http\Handlers\RejectRequestHandler;
use Social\Http\Handlers\RemovePostHandler;
use Social\Http\Handlers\SendFriendRequestPageHandler;
use Social\Http\Handlers\SendFriendRequestHandler;
use Social\Http\Handlers\UserInfoHandler;
use Social\Http\Route;
use Social\Http\Router;

if (preg_match('/\.(?:png|jpg|jpeg|gif|html)$/', $_SERVER["REQUEST_URI"])) {
    return false;
}

require_once 'vendor/autoload.php';
require_once __DIR__ . '/bootstrap.php';

$routes = [
    Route::createGet('/', HomePageHandler::class),

    Route::createGet('/authorization', AuthorizationPageHandler::class),
    Route::createPost('/authorization', AuthorizationHandler::class),

    Route::createGet('/exit', ExitHandler::class),

    Route::createGet('/list-user-posts', ListUserPostsHandler::class),

    Route::createGet('/create-post', CreatePostPageHandler::class),
    Route::createPost('/create-post', CreatePostHandler::class),
    Route::createGet('/remove-post', RemovePostHandler::class),
    Route::createGet('/like-post', LikePostHandler::class),

    Route::createGet('/list-sent-friend-requests', ListSentFriendRequestsPageHandler::class),
    Route::createGet('/list-received-friend-requests', ListReceivedFriendRequestsPageHandler::class),

    Route::createGet('/cancel-request', CancelRequestHandler::class),
    Route::createGet('/reject-request', RejectRequestHandler::class),

    Route::createGet('/send-friend-request', SendFriendRequestHandler::class),
    Route::createPost('/send-friend-request', SendFriendRequestPageHandler::class),

    Route::createGet('/user-info', UserInfoHandler::class)
];

$router = new Router($routes);
$handler = $router->findRequestHandler(
    $_SERVER['REQUEST_METHOD'],
    $_SERVER['PATH_INFO'] ?? '/'
);

if ($handler === null) {
    echo "<h1>Page not found</h1>";

    return;
}

$requestData = $_SERVER['REQUEST_METHOD'] === 'GET'
    ? $_GET
    : $_POST;

$handler->handle($requestData)->render();
