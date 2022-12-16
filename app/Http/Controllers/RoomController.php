<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    public function rooms (Request $request)
    {
        return Room::all();
    }

    public function messages (Request $request, $room_id)
    {
        return Message::where('room_id', $room_id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function newMessage (Request $request, $room_id)
    {
        $newMessage = new Message;
        $newMessage -> user_id = Auth::id();
        $newMessage -> room_id = $room_id;
        $newMessage -> message = $request -> message;
        $newMessage -> save();

        return $newMessage;
    }

}
