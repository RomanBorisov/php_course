<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\SongController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get(
    '/',
    function () {
        return redirect('albums');
    }
);

Route::name('albums.')
    ->prefix('albums')
    ->group(
        function () {
            Route::get('', [AlbumController::class, 'getAll'])
                ->name('list');
            Route::get('{id}', [AlbumController::class, 'getById'])
                ->name('get')
                ->where('id', '[0-9]+');
            Route::post('', [AlbumController::class, 'create'])
                ->name('create');
            Route::get('add', [AlbumController::class, 'createPage'])
                ->name('createPage');
            Route::delete('{id}', [AlbumController::class, 'remove'])
                ->name('remove')
                ->where('id', '[0-9]+');
        }
    );

Route::name('songs.')
    ->prefix('songs')
    ->group(
        function () {
            Route::post('', [SongController::class, 'create'])
                ->name('create');
            Route::get('add/{albumId}', [SongController::class, 'createPage'])
                ->name('createPage')
                ->where('albumId', '[0-9]+');
            Route::delete('{id}/{albumId}', [SongController::class, 'remove'])
                ->name('remove')
                ->where('id', '[0-9]+')
                ->where('albumId', '[0-9]+');
        }
    );
