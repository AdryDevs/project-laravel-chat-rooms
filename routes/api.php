<?php

use App\Http\Controllers\AuthController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/register',[AuthController::class, 'register']);
Route::post('/login',[AuthController::class, 'login']);

//Auth routes

Route::group([
    'middleware' => 'jwt.auth'
], function (){
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);      
    });

// User routes

Route::group([
    'middleware' => ['jwt.auth', 'isSuperAdmin']
], function () {
    Route::get('/users/all', [UserController::class, 'showAllUsers']);
    Route::get('/users/{id}', [UserController::class, 'showUserById']);
    Route::post('/users/create', [UserController::class, 'createNewUser']);
    Route::put('/users/{id}', [UserController::class, 'updateUserById']);
    Route::delete('/users/{id}', [UserController::class, 'deleteUserById']);
});

// Room routes

Route::group([
    'middleware' => ['jwt.auth', 'isAdmin' || 'isSuperAdmin']
], function () {
    Route::get('/rooms/all', [RoomController::class, 'showAllRooms']);
    Route::get('/rooms/{id}', [RoomController::class, 'showRoomById']);
    Route::post('/rooms/create', [RoomController::class, 'createNewRoom']);
    Route::put('/rooms/{id}', [RoomController::class, 'updateRoomById']);
    Route::delete('/rooms/{id}', [RoomController::class, 'deleteRoomById']);
});





