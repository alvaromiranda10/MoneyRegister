<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('logout',[UserController::class, 'logout']);
    Route::get('/user',[UserController::class, 'index']);
});

Route::get('login',[UserController::class, 'login'])->name('login');
Route::post('login',[UserController::class, 'login']);

Route::post('register',[UserController::class, 'register']);