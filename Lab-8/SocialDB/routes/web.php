<?php

use App\Http\Controllers\FriendsController;
use App\Http\Controllers\FriendsRequestController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('auth');

Route::middleware('auth')
    ->name('users')
    ->prefix('users')
    ->group(
        function () {
            Route::get('', [UserController::class, 'getAll']);
            Route::get('/{user}', [UserProfileController::class, 'index'])
                ->name('.profile');
        }
    );

Route::middleware('auth')
    ->name('friends')
    ->prefix('users/{user}/friends')
    ->group(
        function () {
            Route::get('', [FriendsController::class, 'index']);
            Route::post('', [FriendsController::class, 'store'])->name('.send-request');
            Route::delete('', [FriendsController::class, 'destroy'])->name('.remove');

            Route::post('/request/{request}', [FriendsRequestController::class, 'accept'])->name('.request.accept');
            Route::delete('/request/{request}', [FriendsRequestController::class, 'decline'])->name('.request.decline');
            Route::delete('/request/my/{request}', [FriendsRequestController::class, 'cancel'])->name('.request.cancel');

        }
    );


Route::middleware('auth')
    ->name('posts')
    ->prefix('posts')
    ->group(
        function () {

            Route::get('', [PostController::class, 'myPosts']);
            Route::post('', [PostController::class, 'store']);

            Route::delete('/{post}', [PostController::class, 'destroy'])->name('.destroy');

            Route::post('/{post}/likes', [PostLikeController::class, 'store'])->name('.likes');
            Route::delete('/{post}/likes', [PostLikeController::class, 'destroy'])->name('.likes');


        }
    );

Route::get('/news', [NewsController::class, 'index'])->name('news');



