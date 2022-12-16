<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// AUTH
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);


// USERS
Route::group([
    'middleware' => ['jwt.auth', 'isSuperAdmin']
], function () {
    Route::post('/add_super_admin_role/{id}', [UserController::class, 'addSuperAdminRoleByIdUser']);
});


// ROOMS

Route::middleware('auth:sanctum')->get('/chat/rooms', [RoomController::class, 'rooms']);
Route::middleware('auth:sanctum')->get('/chat/rooms/{room_id}/messages', [RoomController::class, 'messages']);
Route::middleware('auth:sanctum')->post('/chat/rooms/{room_id}/messages', [RoomController::class, 'newMessage']);


