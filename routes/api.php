<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use App\Models\User;

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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);


Route::group(['middleware' => 'auth:api'], function () {
    Route::post('/message/{id}', [MessageController::class, 'sendMessage']);
    Route::get('/message/{id}', [MessageController::class, 'receiveMessage']);
    Route::get('/matcheslist', [UserController::class , 'getMatchesList']);
    Route::get('/user', [UserController::class, 'getUserDetails']);
});