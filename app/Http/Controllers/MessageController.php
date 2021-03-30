<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function sendMessage(Request $request) {
        $attributes = $request->validate([
            'content' => 'string',
            'sender_id' => 'integer',
            'receiver_id' => 'integer',
        ]);
        
        $message = Message::create([
            'content' => $attributes['content'],
            'sender_id' => $attributes['sender_id'],
            'receiver_id' => $attributes['receiver_id'],
        ]);

        return response()->json($message, 200);
    }

    public function receiveMessage($id1, $id2) {
        $userMessageHistory = Message::where('receiver_id', $id1)->where('sender_id', $id2)
                                ->orWhere('receiver_id', $id2)->where('sender_id', $id1)->get();

        return response()->json($userMessageHistory, 200);
    }
}
