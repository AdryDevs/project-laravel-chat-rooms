<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;

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

Route::get('/', function () {
    return view('welcome');
});



Route::middleware('auth:sanctum')->get('/chat/rooms', [RoomController::class, 'rooms']);
Route::middleware('auth:sanctum')->get('/chat/rooms/{room_id}/messages', [RoomController::class, 'messages']);
Route::middleware('auth:sanctum')->post('/chat/rooms/{room_id}/messages', [RoomController::class, 'newMessage']);

Route::get ('/messages'. [RoomController::class, 'getMessages']);
Route::post ('/messages'. [RoomController::class, 'newMessage']);
