<?php

use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\GraffitiController;
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
Route::get('/comsa/{id}', [GraffitiController::class,'show']);
Route::get('/new', [GraffitiController::class,'new']);
Route::post('/new', [GraffitiController::class,'store']);

Route::post('/comentar', [ComentarioController::class,'store']);
