<?php

use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\GraffitiController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\FollowerController;
use App\Http\Middleware\AuthSession;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', [GraffitiController::class,'index']);
Route::get('/graffiti/{id}', [GraffitiController::class,'show']);
Route::get('/graffiti/{id}/delete', [GraffitiController::class,'destroy']);
Route::get('/new', function () {
	return response()->view('new');
});
Route::post('/new', [GraffitiController::class,'store']);
Route::post('/buscar', [GraffitiController::class,'search']);

Route::post('/comentar', [ComentarioController::class,'store']);

Route::get('/user/{id}', [UsuarioController::class, 'index']);

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/login/redirect', [LoginController::class, 'redirect']);
Route::get('/login/callback', [LoginController::class, 'callback']);
Route::post('/login', [LoginController::class, 'store']);
Route::get('/logout', [LoginController::class, 'logout']);
Route::get('/profile', [LoginController::class, 'profile'])->middleware('auth');

Route::post('/uploadImage', [GraffitiController::class,'subirImageImgur']);

Route::get('/like/{id}', [LikeController::class,'store'])->middleware('auth');
Route::get('/dislike/{id}', [LikeController::class,'delete'])->middleware('auth');

Route::get('/follow/{id}', [FollowerController::class,'store'])->middleware('auth');
Route::get('/unfollow/{id}', [FollowerController::class,'delete'])->middleware('auth');
