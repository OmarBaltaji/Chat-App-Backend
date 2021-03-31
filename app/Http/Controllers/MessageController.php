<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function sendMessage(Request $request, $id) {
        $attributes = $request->validate([
            'content' => 'string',
        ]);

        $message = Message::create([
            'content' => $attributes['content'],
            'sender_id' => Auth::user()->id,
            'receiver_id' => $id,
        ]);

        broadcast(new MessageSent($attributes['content']));
        
        return response()->json($message, 200);
    }

    public function conversationHistory($id) {
        $authenticatedUserId = Auth::user()->id;
        $userMessageHistory = Message::where('receiver_id', $authenticatedUserId)->where('sender_id', $id)
                                ->orWhere('receiver_id', $id)->where('sender_id', $authenticatedUserId)->get();

        return response()->json($userMessageHistory, 200);
    }
}
